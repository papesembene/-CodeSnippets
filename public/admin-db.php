<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/config/env.php';

EnvLoader::load();

try {
    $db = new \App\Core\DataBase();
    $pdo = $db->getConnection();
    
    // Récupérer tous les snippets
    $stmt = $pdo->query("SELECT * FROM code_snippets ORDER BY created_at DESC");
    $snippets = $stmt->fetchAll();
    
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DB - CodeSnippets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">🗃️ Administration Base de Données</h1>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Erreur:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">📊 Informations</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-semibold">Type de DB:</span>
                    <?php 
                    $info = $db->getConnectionInfo();
                    if (str_contains($info['host'], 'tmp') || str_contains($info['host'], 'sqlite')) {
                        echo '<span class="text-orange-600">SQLite (Fallback)</span>';
                    } else {
                        echo '<span class="text-green-600">PostgreSQL</span>';
                    }
                    ?>
                </div>
                <div>
                    <span class="font-semibold">Total snippets:</span>
                    <?= isset($snippets) ? count($snippets) : 0 ?>
                </div>
            </div>
        </div>

        <?php if (isset($snippets) && count($snippets) > 0): ?>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold">📝 Code Snippets</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créé le</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($snippets as $snippet): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?= $snippet['id'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= htmlspecialchars($snippet['title']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?= htmlspecialchars($snippet['category']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d/m/Y H:i', strtotime($snippet['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="showCode(<?= $snippet['id'] ?>)" class="text-blue-600 hover:text-blue-900">
                                            Voir le code
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">Aucun snippet trouvé</p>
                <a href="/" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                    Créer le premier snippet
                </a>
            </div>
        <?php endif; ?>

        <!-- Modal pour afficher le code -->
        <div id="codeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-4xl w-full max-h-96 overflow-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Code du snippet</h3>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">✕</button>
                        </div>
                        <pre id="codeContent" class="bg-gray-100 p-4 rounded overflow-auto text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const snippets = <?= json_encode($snippets ?? []) ?>;
        
        function showCode(id) {
            const snippet = snippets.find(s => s.id == id);
            if (snippet) {
                document.getElementById('codeContent').textContent = snippet.code_content;
                document.getElementById('codeModal').classList.remove('hidden');
            }
        }
        
        function closeModal() {
            document.getElementById('codeModal').classList.add('hidden');
        }
    </script>
</body>
</html>
