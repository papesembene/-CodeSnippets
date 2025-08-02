<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/config/env.php';

// Charger l'environnement
EnvLoader::load();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Déploiement - CodeSnippets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">🚀 État du déploiement Railway</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- État de l'application -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-green-600 mb-4">✅ Application</h2>
                    <p class="text-gray-600">L'application fonctionne correctement</p>
                    <p class="text-sm text-gray-500 mt-2">PHP 8.1 + Tailwind CSS</p>
                </div>
                
                <!-- État de la base de données -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-yellow-600 mb-4">⚠️ Base de données</h2>
                    <p class="text-gray-600">Mode SQLite temporaire</p>
                    <p class="text-sm text-gray-500 mt-2">PostgreSQL à configurer dans Railway</p>
                </div>
            </div>
            
            <!-- Variables d'environnement importantes -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">🔧 Configuration</h2>
                <div class="space-y-2 font-mono text-sm">
                    <?php
                    $importantVars = [
                        'RAILWAY_ENVIRONMENT' => $_ENV['RAILWAY_ENVIRONMENT'] ?? 'NON DÉFINIE',
                        'PORT' => $_ENV['PORT'] ?? 'NON DÉFINIE',
                        'DATABASE_URL' => isset($_ENV['DATABASE_URL']) ? 'DÉFINIE' : 'NON DÉFINIE',
                        'POSTGRES_USER' => $_ENV['POSTGRES_USER'] ?? 'NON DÉFINIE',
                        'POSTGRES_DB' => $_ENV['POSTGRES_DB'] ?? 'NON DÉFINIE',
                        'RAILWAY_PRIVATE_DOMAIN' => $_ENV['RAILWAY_PRIVATE_DOMAIN'] ?? 'NON DÉFINIE'
                    ];
                    
                    foreach ($importantVars as $var => $value) {
                        $status = $value === 'NON DÉFINIE' ? 'text-red-600' : 'text-green-600';
                        echo "<div class='flex justify-between'>";
                        echo "<span class='text-gray-700'>$var:</span>";
                        echo "<span class='$status'>$value</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">📋 Pour configurer PostgreSQL</h2>
                <ol class="list-decimal list-inside space-y-2 text-blue-700">
                    <li>Aller dans votre projet Railway</li>
                    <li>Cliquer sur "+ Add Service"</li>
                    <li>Sélectionner "PostgreSQL"</li>
                    <li>Attendre que les variables soient générées</li>
                    <li>Redéployer l'application</li>
                </ol>
            </div>
            
            <!-- Liens utiles -->
            <div class="flex justify-center space-x-4 mt-8">
                <a href="/" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                    Voir l'application
                </a>
                <a href="https://railway.app" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                    Aller sur Railway
                </a>
            </div>
        </div>
    </div>
</body>
</html>
