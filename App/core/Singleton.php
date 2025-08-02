<?php

namespace App\Core;

/**
 * Classe abstraite Singleton
 * Implémente le pattern Singleton pour une instance unique
 */
abstract class Singleton
{
    private static array $instances = [];

    /**
     * Le constructeur doit être protected pour empêcher l'instanciation directe
     */
    protected function __construct() {}

    /**
     * Empêche le clonage de l'instance
     */
    protected function __clone() {}

    /**
     * Empêche la désérialisation de l'instance
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Récupère l'instance unique de la classe
     */
    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
}
