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
    
    // Créer les tables directement (compatible PostgreSQL)
    echo "📝 Création de la table code_snippets...\n";
    
    $sql = "
    CREATE TABLE IF NOT EXISTS code_snippets (
        id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        code_content TEXT NOT NULL,
        category VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE INDEX IF NOT EXISTS idx_code_snippets_category ON code_snippets(category);
    CREATE INDEX IF NOT EXISTS idx_code_snippets_created_at ON code_snippets(created_at);
    ";
    
    $pdo->exec($sql);
    echo "✅ Table code_snippets créée avec succès\n";
    
    // Ajouter quelques données de test
    echo "📝 Ajout de données de test...\n";
    $insertSql = "
    INSERT INTO code_snippets (title, description, code_content, category) 
    VALUES 
        ('Hello World PHP', 'Un simple Hello World en PHP', '<?php\necho \"Hello, World!\";', 'PHP'),
        ('Button HTML', 'Un bouton HTML stylé', '<button class=\"btn btn-primary\">Cliquez ici</button>', 'HTML'),
        ('CSS Flexbox', 'Centrer un élément avec flexbox', '.container {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n}', 'CSS')
    ON CONFLICT DO NOTHING;
    ";
    
    $pdo->exec($insertSql);
    echo "✅ Données de test ajoutées\n";
    
    echo "🎉 Toutes les migrations ont été exécutées avec succès!\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors des migrations: " . $e->getMessage() . "\n";
    exit(1);
}
