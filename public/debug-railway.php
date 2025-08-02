<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/config/env.php';

EnvLoader::load();

echo "<h1>🔍 DEBUG Railway Variables</h1>";

echo "<h2>Variables disponibles:</h2>";
$vars = ['PGHOST', 'PGUSER', 'PGPASSWORD', 'PGDATABASE', 'PGPORT', 
         'POSTGRES_USER', 'POSTGRES_PASSWORD', 'POSTGRES_DB', 'RAILWAY_PRIVATE_DOMAIN',
         'DATABASE_URL'];

foreach ($vars as $var) {
    $value = EnvLoader::get($var);
    if ($value && str_contains(strtolower($var), 'pass')) {
        echo "$var = [MASQUÉ]<br>";
    } else {
        echo "$var = " . ($value ?: 'NON DÉFINIE') . "<br>";
    }
}

echo "<h2>Test DataBase:</h2>";
try {
    $db = new \App\Core\DataBase();
    $info = $db->getConnectionInfo();
    echo "Host utilisé: " . $info['host'] . "<br>";
    echo "Port utilisé: " . $info['port'] . "<br>";
    echo "DB utilisée: " . $info['database'] . "<br>";
    echo "User utilisé: " . $info['username'] . "<br>";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
