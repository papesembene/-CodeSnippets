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
        
        // Vérifier si on a une DATABASE_URL (format Railway/Heroku)
        $databaseUrl = \EnvLoader::get('DATABASE_URL');
        
        if ($databaseUrl) {
            // Parser l'URL de la base de données
            $parsedUrl = parse_url($databaseUrl);
            $this->host = $parsedUrl['host'] ?? 'localhost';
            $this->port = $parsedUrl['port'] ?? '5432';
            $this->database = ltrim($parsedUrl['path'] ?? '', '/');
            $this->username = $parsedUrl['user'] ?? 'postgres';
            $this->password = $parsedUrl['pass'] ?? '';
        } else {
            // Configuration PostgreSQL depuis variables individuelles
            $this->host = \EnvLoader::get('DB_HOST', 'localhost');
            $this->port = \EnvLoader::get('DB_PORT', '5432');
            $this->database = \EnvLoader::get('DB_DATABASE', 'code_snippets_db');
            $this->username = \EnvLoader::get('DB_USERNAME', 'postgres');
            $this->password = \EnvLoader::get('DB_PASSWORD', '');
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
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database}";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch (PDOException $e) {
            throw new \Exception("Erreur de connexion à la base de données PostgreSQL: " . $e->getMessage());
        }
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
