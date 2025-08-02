<?php

/**
 * Script de migration pour Railway
 * Exécute les migrations de base de données automatiquement au déploiement
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/App/config/env.php';

// Charger l'environnement
EnvLoader::load();

try {
    echo "🚀 Début des migrations...\n";
    
    // Inclure la classe Database
    require_once __DIR__ . '/App/core/Singleton.php';
    require_once __DIR__ . '/App/core/DataBase.php';
    
    // Obtenir la connexion
    $db = App\Core\DataBase::getInstance();
    $pdo = $db->getConnection();
    
    echo "✅ Connexion à la base de données établie\n";
    
    // Lire et exécuter les migrations SQL
    $migrationFiles = [
        __DIR__ . '/database/migrations/2025_02_08_000001_create_code_snippets_table.sql',
        __DIR__ . '/database/migrations/2025_02_08_000002_add_indexes_to_code_snippets.sql'
    ];
    
    foreach ($migrationFiles as $file) {
        if (file_exists($file)) {
            echo "📝 Exécution de " . basename($file) . "...\n";
            $sql = file_get_contents($file);
            
            // Exécuter la migration
            $pdo->exec($sql);
            echo "✅ Migration " . basename($file) . " terminée\n";
        } else {
            echo "⚠️ Fichier de migration non trouvé: " . basename($file) . "\n";
        }
    }
    
    echo "🎉 Toutes les migrations ont été exécutées avec succès!\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors des migrations: " . $e->getMessage() . "\n";
    exit(1);
}
