<?php

/**
 * Chargeur de variables d'environnement
 * Charge les variables depuis le fichier .env
 */
class EnvLoader
{
    private static array $env = [];
    private static bool $loaded = false;

    /**
     * Charge les variables d'environnement depuis le fichier .env
     */
    public static function load(string $envFile = null): void
    {
        if (self::$loaded) {
            return;
        }

        $envFile = $envFile ?: __DIR__ . '/../../.env';

        if (!file_exists($envFile)) {
            throw new Exception("Le fichier d'environnement '$envFile' n'existe pas.");
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignorer les commentaires
            if (empty($line) || $line[0] === '#') {
                continue;
            }

            // Parser la ligne KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Supprimer les guillemets si présents
                if (strlen($value) >= 2 && 
                    (($value[0] === '"' && $value[-1] === '"') || 
                     ($value[0] === "'" && $value[-1] === "'"))) {
                    $value = substr($value, 1, -1);
                }

                // Stocker dans $_ENV et notre cache local
                $_ENV[$key] = $value;
                self::$env[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Récupère une variable d'environnement
     */
    public static function get(string $key, $default = null)
    {
        self::load();

        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (isset(self::$env[$key])) {
            return self::$env[$key];
        }

        return $default;
    }

    /**
     * Vérifie si une variable d'environnement existe
     */
    public static function has(string $key): bool
    {
        self::load();
        return isset($_ENV[$key]) || isset(self::$env[$key]);
    }

    /**
     * Récupère toutes les variables d'environnement
     */
    public static function all(): array
    {
        self::load();
        return array_merge(self::$env, $_ENV);
    }
}
