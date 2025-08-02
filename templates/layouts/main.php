<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CodeSnippets - Bibliothèque de Codes' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Prism.js pour la coloration syntaxique -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
    
    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="/assets/css/app.css">
    
    <!-- Configuration Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['Fira Code', 'ui-monospace', 'monospace'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Icônes Heroicons -->
    <script src="https://unpkg.com/@heroicons/react@2.0.18/24/outline/index.js" type="module"></script>
</head>
<body class="h-full bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 text-xl font-semibold text-gray-900">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <span>CodeSnippets</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex items-center space-x-4">
                    <a href="/" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                        Accueil
                    </a>
                    <a href="/snippets/create" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 transition-colors flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Ajouter un code</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Messages de feedback -->
    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Code snippet ajouté avec succès !
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <?php if ($_GET['error'] == 'not_found'): ?>
                        Code snippet non trouvé.
                    <?php else: ?>
                        Une erreur est survenue lors de l'ajout du code.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; MR SEM'S. Créé   pour les développeurs.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="/assets/js/app.js"></script>
    
    <!-- Script spécifique à la page -->
    <?php if (isset($pageScript)): ?>
        <script src="/assets/js/<?= $pageScript ?>.js"></script>
    <?php endif; ?>
</body>
</html>
