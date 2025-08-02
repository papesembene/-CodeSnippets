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
        
        // Priorité 1: Variables Railway PostgreSQL
        $pgHost = \EnvLoader::get('PGHOST');
        $pgUser = \EnvLoader::get('PGUSER');
        $pgPassword = \EnvLoader::get('PGPASSWORD');
        $pgDatabase = \EnvLoader::get('PGDATABASE');
        $pgPort = \EnvLoader::get('PGPORT');
        
        // Priorité 2: Variables Railway alternatives
        if (!$pgHost || str_contains($pgHost, '${{')) {
            $pgHost = \EnvLoader::get('RAILWAY_PRIVATE_DOMAIN'); // Utiliser directement le domaine Railway
            $pgUser = \EnvLoader::get('POSTGRES_USER');
            $pgPassword = \EnvLoader::get('POSTGRES_PASSWORD');
            $pgDatabase = \EnvLoader::get('POSTGRES_DB');
        }
        
        if ($pgHost && $pgUser && $pgPassword && $pgDatabase) {
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
        try {
            // Mode développement : si pas de config DB complète, utiliser SQLite temporaire
            if ($this->host === 'localhost' && empty($this->password)) {
                $this->connectSqliteTemporary();
                return;
            }
            
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            // En cas d'échec, essayer SQLite temporaire
            $this->connectSqliteTemporary();
        }
    }
    
    /**
     * Connexion SQLite temporaire pour le développement
     */
    private function connectSqliteTemporary(): void
    {
        try {
            $sqliteFile = '/tmp/codesnippets_temp.sqlite';
            $dsn = "sqlite:$sqliteFile";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, null, null, $options);
            
            // Créer la table des snippets si elle n'existe pas
            $this->createSqliteSchema();
            
        } catch (PDOException $e) {
            throw new \Exception("Impossible de créer une base SQLite temporaire: " . $e->getMessage());
        }
    }
    
    /**
     * Crée le schéma SQLite temporaire
     */
    private function createSqliteSchema(): void
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS code_snippets (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            code_content TEXT NOT NULL,
            category VARCHAR(100) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        INSERT OR IGNORE INTO code_snippets (id, title, description, code_content, category) VALUES 
        (1, 'Hello World PHP', 'Un simple Hello World en PHP', '<?php\necho \"Hello, World!\";', 'PHP'),
        (2, 'Button HTML', 'Un bouton HTML stylé', '<button class=\"btn btn-primary\">Cliquez ici</button>', 'HTML'),
        (3, 'CSS Flexbox', 'Centre un élément avec flexbox', '.container {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n}', 'CSS');
        ";
        
        $this->connection->exec($sql);
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
