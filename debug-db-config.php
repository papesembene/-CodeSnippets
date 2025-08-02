<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/App/config/env.php';

echo "🔍 DEBUG - Configuration Base de Données\n";
echo "==========================================\n\n";

// Charger les variables d'environnement
\EnvLoader::load();

echo "🌐 Variables d'environnement importantes :\n";
$vars = ['PGHOST', 'PGUSER', 'PGPASSWORD', 'PGDATABASE', 'PGPORT', 
         'POSTGRES_USER', 'POSTGRES_PASSWORD', 'POSTGRES_DB', 'RAILWAY_PRIVATE_DOMAIN',
         'DATABASE_URL', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];

foreach ($vars as $var) {
    $value = \EnvLoader::get($var);
    if ($value) {
        if (str_contains(strtolower($var), 'pass') || str_contains(strtolower($var), 'url')) {
            echo "$var = [MASQUÉ - " . strlen($value) . " caractères]\n";
        } else {
            echo "$var = $value\n";
        }
    } else {
        echo "$var = NON DÉFINIE\n";
    }
}

echo "\n🔧 Test de la classe DataBase :\n";
try {
    $db = new \App\Core\DataBase();
    $info = $db->getConnectionInfo();
    echo "Configuration utilisée :\n";
    echo "- Host: " . $info['host'] . "\n";
    echo "- Port: " . $info['port'] . "\n";
    echo "- Database: " . $info['database'] . "\n";
    echo "- Username: " . $info['username'] . "\n";
    
    echo "\n🧪 Test de connexion...\n";
    if ($db->testConnection()) {
        echo "✅ Connexion réussie !\n";
    } else {
        echo "❌ Connexion échouée !\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
