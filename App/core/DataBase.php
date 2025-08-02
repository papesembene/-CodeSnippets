<?php

namespace App\Core;

use PDO;
use PDOException;

// Charger les variables d'environnement
require_once __DIR__ . '/../config/env.php';

class DataBase extends Singleton
{
    private ?PDO $connection = null;
    
    // Configuration de la base de données depuis l'environnement
    private string $host;
    private string $port;
    private string $database;
    private string $username;
    private string $password;

    public function __construct()
    {
        // Charger les variables d'environnement
        \EnvLoader::load();
        
        // Fonction pour lire une variable avec fallback système
        $getVar = function($key) {
            return \EnvLoader::get($key) ?: ($_ENV[$key] ?? ($_SERVER[$key] ?? getenv($key)));
        };
        
        // Priorité 1: Variables Railway PostgreSQL
        $pgHost = $getVar('PGHOST');
        $pgUser = $getVar('PGUSER'); 
        $pgPassword = $getVar('PGPASSWORD');
        $pgDatabase = $getVar('PGDATABASE');
        $pgPort = $getVar('PGPORT');
        
        // Priorité 2: Variables Railway alternatives (POSTGRES_*)
        if (empty($pgHost)) {
            $pgHost = $getVar('RAILWAY_PRIVATE_DOMAIN');
            $pgUser = $getVar('POSTGRES_USER');
            $pgPassword = $getVar('POSTGRES_PASSWORD');
            $pgDatabase = $getVar('POSTGRES_DB');
        }
        
        if (!empty($pgHost) && !empty($pgUser) && !empty($pgPassword) && !empty($pgDatabase)) {
            // Utiliser les variables PostgreSQL Railway
            $this->host = $pgHost;
            $this->port = $pgPort ?: '5432';
            $this->database = $pgDatabase;
            $this->username = $pgUser;
            $this->password = $pgPassword;
        } else {
            // Priorité 3: Essayer de parser DATABASE_URL
            $databaseUrl = \EnvLoader::get('DATABASE_URL');
            
            if ($databaseUrl && !str_contains($databaseUrl, '${{')) {
                // Parser l'URL seulement si elle ne contient pas de templates
                $parsedUrl = parse_url($databaseUrl);
                $this->host = $parsedUrl['host'] ?? 'localhost';
                $this->port = $parsedUrl['port'] ?? '5432';
                $this->database = ltrim($parsedUrl['path'] ?? '', '/');
                $this->username = $parsedUrl['user'] ?? 'postgres';
                $this->password = $parsedUrl['pass'] ?? '';
            } else {
                // Priorité 4: Variables locales (.env)
                $this->host = \EnvLoader::get('DB_HOST', 'localhost');
                $this->port = \EnvLoader::get('DB_PORT', '5432');
                $this->database = \EnvLoader::get('DB_DATABASE', 'code_snippets_db');
                $this->username = \EnvLoader::get('DB_USERNAME', 'postgres');
                $this->password = \EnvLoader::get('DB_PASSWORD', '');
            }
        }
    }

    /**
     * Obtient la connexion PDO
     */
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connect();
        }
        
        return $this->connection;
    }

    /**
     * Établit la connexion à la base de données PostgreSQL
     */
    private function connect(): void
    {
        $maxRetries = 1;
        $retryDelay = 1; // secondes
        
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";
                
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_TIMEOUT => 10
                ];

                $this->connection = new PDO($dsn, $this->username, $this->password, $options);
                return; // Connexion réussie
                
            } catch (PDOException $e) {
                if ($attempt === $maxRetries) {
                    throw new \Exception("PostgreSQL connexion impossible après $maxRetries tentatives: " . $e->getMessage() . 
                        " | Host: {$this->host} | Port: {$this->port} | DB: {$this->database} | User: {$this->username}");
                }
                
                // Attendre avant la prochaine tentative
                sleep($retryDelay);
            }
        }
    }

    /**
     * Connexion SQLite de fallback
     */
    private function connectSQLiteFallback(): void
    {
        try {
            $dbPath = '/tmp/codesnippets.db';
            $dsn = "sqlite:$dbPath";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, null, null, $options);
            
            // Créer les tables si elles n'existent pas
            $this->createSQLiteTables();
            
        } catch (PDOException $e) {
            throw new \Exception("Erreur fallback SQLite: " . $e->getMessage());
        }
    }

    /**
     * Créer les tables SQLite de base
     */
    private function createSQLiteTables(): void
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS code_snippets (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            category VARCHAR(50) NOT NULL DEFAULT 'PHP',
            code_content TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->connection->exec($sql);
        
        // Créer des index pour performance
        $this->connection->exec("CREATE INDEX IF NOT EXISTS idx_category ON code_snippets(category)");
        $this->connection->exec("CREATE INDEX IF NOT EXISTS idx_created_at ON code_snippets(created_at DESC)");
    }

    /**
     * Teste la connexion à la base de données
     */
    public function testConnection(): bool
    {
        try {
            $this->getConnection();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Ferme la connexion
     */
    public function disconnect(): void
    {
        $this->connection = null;
    }

    /**
     * Récupère les paramètres de connexion pour debug
     */
    public function getConnectionInfo(): array
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'database' => $this->database,
            'username' => $this->username
        ];
    }
}
