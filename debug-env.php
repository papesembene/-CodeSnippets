<?php

/**
 * Script de debug pour voir les variables d'environnement Railway
 */

echo "🔍 DEBUG - Variables d'environnement Railway\n";
echo "==========================================\n\n";

echo "🌐 Toutes les variables disponibles :\n";
foreach ($_ENV as $key => $value) {
    // Masquer les valeurs sensibles mais montrer qu'elles existent
    if (strpos(strtolower($key), 'pass') !== false || 
        strpos(strtolower($key), 'secret') !== false ||
        strpos(strtolower($key), 'token') !== false) {
        echo "$key = [MASQUÉ - " . strlen($value) . " caractères]\n";
    } else {
        echo "$key = $value\n";
    }
}

echo "\n📊 Variables importantes pour la DB :\n";
$dbVars = ['DATABASE_URL', 'DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS', 'PGHOST', 'PGPORT', 'PGDATABASE', 'PGUSER', 'PGPASSWORD', 'POSTGRES_HOST', 'POSTGRES_USER', 'POSTGRES_PASSWORD', 'POSTGRES_DB', 'RAILWAY_PRIVATE_DOMAIN', 'RAILWAY_TCP_PROXY_DOMAIN'];

foreach ($dbVars as $var) {
    $value = $_ENV[$var] ?? 'NON DÉFINIE';
    if ($value !== 'NON DÉFINIE' && (strpos(strtolower($var), 'pass') !== false)) {
        echo "$var = [MASQUÉ - " . strlen($value) . " caractères]\n";
    } else {
        echo "$var = $value\n";
    }
}

echo "\n🔗 Test de parsing DATABASE_URL :\n";
if (isset($_ENV['DATABASE_URL'])) {
    $url = $_ENV['DATABASE_URL'];
    $parsed = parse_url($url);
    echo "HOST: " . ($parsed['host'] ?? 'NON TROUVÉ') . "\n";
    echo "PORT: " . ($parsed['port'] ?? 'NON TROUVÉ') . "\n";
    echo "DB: " . ltrim($parsed['path'] ?? '', '/') . "\n";
    echo "USER: " . ($parsed['user'] ?? 'NON TROUVÉ') . "\n";
    echo "PASS: " . (isset($parsed['pass']) ? '[MASQUÉ - ' . strlen($parsed['pass']) . ' caractères]' : 'NON TROUVÉ') . "\n";
} else {
    echo "❌ DATABASE_URL non trouvée !\n";
}

echo "\n🔧 Test de résolution des variables Railway :\n";
$railwayDomain = $_ENV['RAILWAY_PRIVATE_DOMAIN'] ?? 'NON TROUVÉ';
$postgresUser = $_ENV['POSTGRES_USER'] ?? 'NON TROUVÉ';
$postgresPassword = $_ENV['POSTGRES_PASSWORD'] ?? 'NON TROUVÉ';
$postgresDb = $_ENV['POSTGRES_DB'] ?? 'NON TROUVÉ';

echo "RAILWAY_PRIVATE_DOMAIN: $railwayDomain\n";
echo "POSTGRES_USER: $postgresUser\n";
echo "POSTGRES_PASSWORD: " . (($postgresPassword !== 'NON TROUVÉ') ? '[MASQUÉ]' : 'NON TROUVÉ') . "\n";
echo "POSTGRES_DB: $postgresDb\n";

if ($railwayDomain !== 'NON TROUVÉ' && $postgresUser !== 'NON TROUVÉ' && $postgresPassword !== 'NON TROUVÉ' && $postgresDb !== 'NON TROUVÉ') {
    echo "\n🎯 Configuration PostgreSQL construite :\n";
    echo "HOST: $railwayDomain\n";
    echo "PORT: 5432\n";
    echo "DATABASE: $postgresDb\n";
    echo "USER: $postgresUser\n";
    echo "PASSWORD: [MASQUÉ]\n";
    
    $constructedUrl = "postgresql://$postgresUser:[MASQUÉ]@$railwayDomain:5432/$postgresDb";
    echo "URL CONSTRUITE: $constructedUrl\n";
} else {
    echo "❌ Variables manquantes pour construire la config DB\n";
}

echo "\n✅ Debug terminé. (v2.0)\n";
