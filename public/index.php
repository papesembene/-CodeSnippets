<?php

// Point d'entrée de l'application Code Snippets

// Chargement de l'autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement
require_once __DIR__ . '/../App/config/env.php';
EnvLoader::load();

// Gestion des erreurs selon l'environnement
$debug = EnvLoader::get('APP_DEBUG', 'false') === 'true';
if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Utilisation du routeur du framework
use App\Router\Router;

try {
    // Création du routeur
   

    // Chargement des routes web
    $routes = require_once __DIR__ . '/../route/web.php';

    // Chargement des routes API
    // require_once __DIR__ . '/../route/api.php';

    // Démarrage du routeur
Router::resolve($routes);
    
} catch (Exception $e) {
    // Gestion des erreurs
    http_response_code(500);
    echo "<h1>Erreur de l'application</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Fichier:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Ligne:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
