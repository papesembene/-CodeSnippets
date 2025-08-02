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
$dbVars = ['DATABASE_URL', 'DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS', 'PGHOST', 'PGPORT', 'PGDATABASE', 'PGUSER', 'PGPASSWORD'];

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

echo "\n✅ Debug terminé.\n";
