/**
 * Script pour améliorer l'expérience utilisateur des filtres et pagination
 */

class FilterManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupAutoSubmit();
    }

    /**
     * Configuration des événements
     */
    setupEventListeners() {
        // Auto-soumission du formulaire quand on change les sélects
        const categorySelect = document.getElementById('category-select');
        const perPageSelect = document.getElementById('per-page-select');

        if (categorySelect) {
            categorySelect.addEventListener('change', () => {
                this.submitFormWithReset();
            });
        }

        if (perPageSelect) {
            perPageSelect.addEventListener('change', () => {
                this.submitFormWithReset();
            });
        }

        // Recherche avec debounce
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.submitFormWithReset();
            }, 1000)); // Attendre 1 seconde après l'arrêt de la saisie
        }
    }

    /**
     * Soumission du formulaire en remettant la page à 1
     */
    submitFormWithReset() {
        const form = document.querySelector('form');
        const pageInput = document.querySelector('input[name="page"]');
        
        if (pageInput) {
            pageInput.value = 1; // Remettre à la première page
        }
        
        if (form) {
            form.submit();
        }
    }

    /**
     * Configuration pour l'auto-soumission
     */
    setupAutoSubmit() {
        // Masquer le bouton de soumission si JavaScript est activé
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.style.display = 'none';
        }

        // Ajouter un indicateur de chargement
        this.addLoadingIndicator();
    }

    /**
     * Ajoute un indicateur de chargement
     */
    addLoadingIndicator() {
        const form = document.querySelector('form');
        if (!form) return;

        const indicator = document.createElement('div');
        indicator.id = 'loading-indicator';
        indicator.className = 'hidden fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        indicator.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Filtrage en cours...</span>
            </div>
        `;
        
        document.body.appendChild(indicator);

        // Afficher l'indicateur lors de la soumission
        form.addEventListener('submit', () => {
            indicator.classList.remove('hidden');
        });
    }

    /**
     * Utility function debounce
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Affiche/masque les options avancées
     */
    toggleAdvancedOptions() {
        const advancedDiv = document.getElementById('advanced-options');
        if (advancedDiv) {
            advancedDiv.classList.toggle('hidden');
        }
    }
}

// Gestion des raccourcis clavier
class KeyboardShortcuts {
    constructor() {
        this.setupKeyboardShortcuts();
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K pour focus sur la recherche
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.getElementById('search');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            }

            // Échapper pour vider la recherche
            if (e.key === 'Escape') {
                const searchInput = document.getElementById('search');
                if (searchInput && document.activeElement === searchInput) {
                    searchInput.value = '';
                    searchInput.blur();
                    // Optionnellement soumettre pour effacer les résultats
                    const form = document.querySelector('form');
                    if (form) {
                        form.submit();
                    }
                }
            }
        });
    }
}

// Gestion des URLs et historique
class URLManager {
    constructor() {
        this.setupURLHandling();
    }

    setupURLHandling() {
        // Gestion du bouton retour du navigateur
        window.addEventListener('popstate', (e) => {
            // Recharger la page pour afficher les bons résultats
            window.location.reload();
        });
    }

    /**
     * Met à jour l'URL sans recharger la page (pour les filtres en temps réel)
     */
    updateURL(params) {
        const url = new URL(window.location);
        
        // Nettoyer les paramètres existants
        url.searchParams.delete('category');
        url.searchParams.delete('search');
        url.searchParams.delete('page');
        url.searchParams.delete('per_page');
        
        // Ajouter les nouveaux paramètres
        Object.keys(params).forEach(key => {
            if (params[key] && params[key] !== '' && params[key] !== 'all') {
                url.searchParams.set(key, params[key]);
            }
        });
        
        window.history.pushState({}, '', url);
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    new FilterManager();
    new KeyboardShortcuts();
    new URLManager();
    
    // Afficher un message d'aide pour les raccourcis
    console.log('💡 Raccourcis clavier disponibles:');
    console.log('   Ctrl/Cmd + K : Focus sur la recherche');
    console.log('   Échap : Vider la recherche');
});
