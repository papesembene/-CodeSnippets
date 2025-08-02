<?php
$title = 'Détail - ' . $snippet->getTitle();
?>

<div class="max-w-7xl mx-auto">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($snippet->getTitle()) ?></h1>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $snippet->getCategory() === 'PHP' ? 'bg-blue-100 text-blue-800' : ($snippet->getCategory() === 'HTML' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') ?>">
                <?= $snippet->getCategory() ?>
            </span>
        </div>
        <a href="/" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Retour à l'accueil
        </a>
    </div>

    <!-- Informations du snippet -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <h5 class="flex items-center text-lg font-semibold text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Description
            </h5>
            <p class="text-gray-600 mb-6">
                <?= $snippet->getDescription() ? htmlspecialchars($snippet->getDescription()) : '<em class="text-gray-400">Aucune description fournie</em>' ?>
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Ajouté le <?= $snippet->getCreatedAt()->format('d/m/Y à H:i') ?>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Modifié le <?= $snippet->getUpdatedAt()->format('d/m/Y à H:i') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Code complet -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h5 class="flex items-center text-lg font-semibold text-gray-900 mb-0">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                Code complet
            </h5>
            <div class="flex items-center space-x-2">
                <button class="copy-btn inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copier le code
                </button>
                <button class="fullscreen-btn inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    Plein écran
                </button>
            </div>
        </div>
        <div class="code-container relative">
            <pre class="mb-0 p-6 bg-gray-900 text-gray-100 overflow-x-auto" id="mainCodeBlock"><code class="language-<?= strtolower($snippet->getCategory()) ?>"><?= htmlspecialchars($snippet->getCodeContent()) ?></code></pre>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex flex-wrap justify-center gap-4">
        <a href="/" class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Accueil
        </a>
        <a href="/snippets/create" class="inline-flex items-center px-4 py-2 border border-green-300 rounded-lg text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajouter un nouveau code
        </a>
        <a href="/?category=<?= $snippet->getCategory() ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-gray-50 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Voir tous les codes <?= $snippet->getCategory() ?>
        </a>
    </div>

    <!-- Codes similaires -->
    <div class="mt-12">
        <h4 class="flex items-center text-xl font-semibold text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Codes similaires (<?= $snippet->getCategory() ?>)
        </h4>
        <div id="similarSnippets">
            <div class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500" role="status">
                    <span class="sr-only">Chargement...</span>
                </div>
                <p class="mt-2 text-gray-600">Chargement des codes similaires...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal plein écran -->
<div id="fullscreenModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full h-full max-w-7xl max-h-full flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h5 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($snippet->getTitle()) ?></h5>
            <div class="flex items-center space-x-2">
                <button class="copy-btn-modal inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copier
                </button>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex-1 code-container overflow-hidden">
            <pre class="h-full p-6 bg-gray-900 text-gray-100 overflow-auto text-sm"><code class="language-<?= strtolower($snippet->getCategory()) ?>"><?= htmlspecialchars($snippet->getCodeContent()) ?></code></pre>
        </div>
    </div>
</div>

<script>
// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé dans show.php');
    
    // Configuration des boutons de copie
    const copyBtn = document.querySelector('.copy-btn');
    const copyBtnModal = document.querySelector('.copy-btn-modal');
    const fullscreenBtn = document.querySelector('.fullscreen-btn');
    const modal = document.getElementById('fullscreenModal');
    const closeModalBtn = document.getElementById('closeModal');
    
    console.log('Boutons trouvés:', {
        copyBtn: !!copyBtn,
        copyBtnModal: !!copyBtnModal,
        fullscreenBtn: !!fullscreenBtn,
        modal: !!modal,
        closeModalBtn: !!closeModalBtn
    });

    // Fonction de copie
    function copyCodeToClipboard(button) {
        console.log('Fonction copyCodeToClipboard appelée', button);
        
        // Trouver le conteneur parent puis chercher le code
        const parentContainer = button.closest('div[class*="bg-white"]') || button.closest('div');
        console.log('Parent container trouvé:', !!parentContainer);
        
        // Chercher le code dans tout le parent ou directement par ID
        let codeElement = document.querySelector('#mainCodeBlock code');
        if (!codeElement && parentContainer) {
            codeElement = parentContainer.querySelector('code');
        }
        
        console.log('Element code trouvé:', !!codeElement);
        
        if (!codeElement) {
            console.error('Element code non trouvé');
            return;
        }
        
        const text = codeElement.textContent;
        console.log('Texte à copier:', text.substring(0, 50) + '...');

        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Copié !
            `;
            button.classList.remove('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            button.classList.add('bg-green-500', 'text-white');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-500', 'text-white');
                button.classList.add('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            }, 2000);
        }).catch(err => {
            console.error('Erreur lors de la copie:', err);
            const originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Erreur
            `;
            button.classList.add('bg-red-500', 'text-white');
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-red-500', 'text-white');
            }, 2000);
        });
    }

    // Fonction de copie pour le modal (structure différente)
    function copyModalCode(button) {
        console.log('Fonction copyModalCode appelée', button);
        
        // Dans le modal, chercher directement dans le modal
        const modalElement = document.getElementById('fullscreenModal');
        const codeElement = modalElement.querySelector('code');
        
        console.log('Modal element trouvé:', !!modalElement);
        console.log('Code element dans modal trouvé:', !!codeElement);
        
        if (!codeElement) {
            console.error('Element code non trouvé dans le modal');
            return;
        }
        
        const text = codeElement.textContent;
        console.log('Texte modal à copier:', text.substring(0, 50) + '...');

        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Copié !
            `;
            button.classList.remove('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            button.classList.add('bg-green-500', 'text-white');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-500', 'text-white');
                button.classList.add('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            }, 2000);
        }).catch(err => {
            console.error('Erreur lors de la copie modal:', err);
        });
    }

    // Événements des boutons de copie
    if (copyBtn) {
        copyBtn.addEventListener('click', () => copyCodeToClipboard(copyBtn));
    }
    
    if (copyBtnModal) {
        copyBtnModal.addEventListener('click', () => copyModalCode(copyBtnModal));
    }

    // Fonction plein écran
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Re-coloriser le code dans le modal
            setTimeout(() => {
                const modalCode = modal.querySelector('code');
                if (window.Prism && modalCode) {
                    Prism.highlightElement(modalCode);
                }
            }, 100);
        });
    }

    // Fermer le modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        });
    }

    // Fermer le modal en cliquant à l'extérieur
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }

    // Fermer le modal avec Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
});

// Charger les codes similaires
document.addEventListener('DOMContentLoaded', function() {
    loadSimilarSnippets();
});

function loadSimilarSnippets() {
    const category = '<?= $snippet->getCategory() ?>';
    const currentId = <?= $snippet->getId() ?>;
    
    fetch(`/api/snippets?category=${category}`)
        .then(response => response.json())
        .then(data => {
            const similarSnippets = data
                .filter(snippet => snippet.id !== currentId)
                .slice(0, 3); // Limiter à 3 résultats
            
            const container = document.getElementById('similarSnippets');
            
            if (similarSnippets.length === 0) {
                container.innerHTML = '<div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">Aucun autre code ' + category + ' trouvé.</div>';
                return;
            }
            
            let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
            similarSnippets.forEach(snippet => {
                html += `
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <h6 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">${escapeHtml(snippet.title)}</h6>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">${escapeHtml(snippet.description || 'Sans description')}</p>
                            <a href="/snippets/show?id=${snippet.id}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Voir le code
                            </a>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        })
        .catch(error => {
            console.error('Erreur lors du chargement des codes similaires:', error);
            document.getElementById('similarSnippets').innerHTML = 
                '<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">Erreur lors du chargement des codes similaires.</div>';
        });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}


</script>
