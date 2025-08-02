<?php

namespace App\Core\Abstract;

use App\Core\DataBase;
use PDO;

/**
 * Classe abstraite pour les repositories
 * Fournit les fonctionnalités de base pour l'accès aux données
 */
abstract class AbstractRepository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    /**
     * Récupère la connexion PDO
     */
    protected function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Exécute une requête SELECT et retourne tous les résultats
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Exécute une requête SELECT et retourne le premier résultat
     */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Exécute une requête INSERT, UPDATE ou DELETE
     */
    protected function execute(string $sql, array $params = []): bool
    {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Retourne l'ID du dernier élément inséré
     */
    protected function getLastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Commence une transaction
     */
    protected function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Valide une transaction
     */
    protected function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Annule une transaction
     */
    protected function rollback(): bool
    {
        return $this->connection->rollback();
    }

    /**
     * Compte le nombre d'éléments selon une condition
     */
    protected function count(string $table, string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) FROM {$table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Vérifie si un enregistrement existe
     */
    protected function exists(string $table, string $where, array $params = []): bool
    {
        return $this->count($table, $where, $params) > 0;
    }
}
