<?php
$title = 'CodeSnippets - Bibliothèque de Codes';
$pageScript = 'filter'; 
?>

<!-- Hero Section -->
<div class="text-center mb-12">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
        Bibliothèque de Codes
    </h1>
    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
        Consultez et partagez des bouts de code utiles
    </p>
    <a href="/snippets/create" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition-colors duration-200 shadow-lg hover:shadow-xl">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Ajouter un nouveau code
    </a>
</div>

<!-- Barre de recherche et filtres -->
<div class="mb-8">
    <form method="GET" action="/" class="space-y-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Barre de recherche -->
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" id="search" value="<?= htmlspecialchars($search) ?>" 
                       placeholder="Rechercher par titre, description ou contenu..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors">
            </div>
            
            <!-- Filtres par catégorie -->
            <div class="flex items-center space-x-2">
                <select name="category" id="category-select" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500   focus:border-blue-500 outline-none">
                    <option  value="all" <?= (!$selectedCategory || $selectedCategory === 'all') ? 'selected' : '' ?>>Toutes catégories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= $selectedCategory === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Nombre d'éléments par page -->
                <select name="per_page" id="per-page-select" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="5" <?= ($pagination['itemsPerPage'] ?? 10) == 5 ? 'selected' : '' ?>>5 par page</option>
                    <option value="10" <?= ($pagination['itemsPerPage'] ?? 10) == 10 ? 'selected' : '' ?>>10 par page</option>
                    <option value="20" <?= ($pagination['itemsPerPage'] ?? 10) == 20 ? 'selected' : '' ?>>20 par page</option>
                    <option value="50" <?= ($pagination['itemsPerPage'] ?? 10) == 50 ? 'selected' : '' ?>>50 par page</option>
                </select>
                
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Filtrer
                </button>
            </div>
        </div>
        
        <!-- Champs cachés pour maintenir la page actuelle lors de la recherche -->
        <input type="hidden" name="page" value="1">
    </form>
    
    <!-- Compteur de résultats et info pagination -->
    <div class="mt-4 flex justify-between items-center">
        <div>
            <p class="text-gray-600" id="results-count">
                <?= $totalResults ?> résultat<?= $totalResults > 1 ? 's' : '' ?> trouvé<?= $totalResults > 1 ? 's' : '' ?>
                <?php if ($search): ?>
                    pour "<strong><?= htmlspecialchars($search) ?></strong>"
                <?php endif; ?>
                <?php if ($selectedCategory && $selectedCategory !== 'all'): ?>
                    dans la catégorie <strong><?= $selectedCategory ?></strong>
                <?php endif; ?>
            </p>
        </div>
        
        <?php if ($pagination['totalPages'] > 1): ?>
            <div class="text-sm text-gray-500">
                Page <?= $pagination['currentPage'] ?> sur <?= $pagination['totalPages'] ?>
                (<?= count($snippets) ?> éléments affichés)
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Liste des snippets -->
<?php if (empty($snippets)): ?>
    <div class="text-center py-12">
        <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun code snippet trouvé</h3>
        <p class="text-gray-600 mb-6">Commencez par ajouter votre premier code !</p>
        <a href="/snippets/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajouter un code
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($snippets as $snippet): ?>
            <div class="snippet-card card-hover bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" 
                 data-category="<?= $snippet->getCategory() ?>">
                <!-- Header de la carte -->
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="snippet-title text-lg font-semibold text-gray-900 line-clamp-2">
                            <?= htmlspecialchars($snippet->getTitle()) ?>
                        </h3>
                        <span class="badge-<?= strtolower($snippet->getCategory()) ?> px-2 py-1 text-xs font-medium rounded-full flex-shrink-0 ml-2">
                            <?= $snippet->getCategory() ?>
                        </span>
                    </div>
                    
                    <p class="snippet-description text-gray-600 text-sm mb-4 line-clamp-2">
                        <?= htmlspecialchars($snippet->getDescription() ?: 'Aucune description fournie') ?>
                    </p>
                </div>
                
                <!-- Actions -->
                <div class="px-6 pb-6">
                    <div class="flex items-center justify-between">
                        <a href="/snippets/show?id=<?= $snippet->getId() ?>" 
                           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Voir le code
                        </a>
                        
                        
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <p class="text-xs text-gray-500">
                        Ajouté le <?= $snippet->getCreatedAt()->format('d/m/Y à H:i') ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($pagination['totalPages'] > 1): ?>
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <!-- Bouton Précédent -->
                <?php if ($pagination['hasPrevious']): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['currentPage'] - 1])) ?>" 
                       class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                <?php else: ?>
                    <span class="px-3 py-2 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                <?php endif; ?>
                
                <!-- Numéros de pages -->
                <?php
                $startPage = max(1, $pagination['currentPage'] - 2);
                $endPage = min($pagination['totalPages'], $pagination['currentPage'] + 2);
                
                if ($startPage > 1): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>" 
                       class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">1</a>
                    <?php if ($startPage > 2): ?>
                        <span class="px-2 text-gray-400">...</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i == $pagination['currentPage']): ?>
                        <span class="px-3 py-2 rounded-lg bg-blue-500 text-white font-medium"><?= $i ?></span>
                    <?php else: ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                           class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($endPage < $pagination['totalPages']): ?>
                    <?php if ($endPage < $pagination['totalPages'] - 1): ?>
                        <span class="px-2 text-gray-400">...</span>
                    <?php endif; ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['totalPages']])) ?>" 
                       class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"><?= $pagination['totalPages'] ?></a>
                <?php endif; ?>
                
                <!-- Bouton Suivant -->
                <?php if ($pagination['hasNext']): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['currentPage'] + 1])) ?>" 
                       class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                <?php else: ?>
                    <span class="px-3 py-2 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                <?php endif; ?>
            </nav>
        </div>
        
        <!-- Informations sur la pagination -->
        <div class="mt-4 text-center text-sm text-gray-600">
            Affichage de <?= (($pagination['currentPage'] - 1) * $pagination['itemsPerPage']) + 1 ?> à 
            <?= min($pagination['currentPage'] * $pagination['itemsPerPage'], $totalResults) ?> 
            sur <?= $totalResults ?> résultats
        </div>
    <?php endif; ?>
<?php endif; ?>

<script>
// Script de test pour le débogage
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé dans index.php');
    
    // Vérifier si les boutons de copie existent
    const copyButtons = document.querySelectorAll('.copy-btn');
    console.log('Nombre de boutons de copie trouvés:', copyButtons.length);
    
    // Vérifier si les conteneurs de code existent
    const codeContainers = document.querySelectorAll('.code-container');
    console.log('Nombre de conteneurs de code trouvés:', codeContainers.length);
    
    // Vérifier si les éléments code existent
    const codeElements = document.querySelectorAll('.code-container code');
    console.log('Nombre d\'éléments code trouvés:', codeElements.length);
    
    // Test direct sur le premier bouton
    if (copyButtons.length > 0) {
        copyButtons[0].addEventListener('click', function(e) {
            console.log('Test: Bouton copie cliqué directement!');
            e.preventDefault();
            
            const container = this.closest('.code-container');
            if (container) {
                const code = container.querySelector('code');
                if (code) {
                    console.log('Code trouvé:', code.textContent.substring(0, 50) + '...');
                } else {
                    console.log('Code non trouvé dans le conteneur');
                }
            } else {
                console.log('Conteneur non trouvé');
            }
        });
    }
});
</script>
