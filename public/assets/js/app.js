/**
 * JavaScript principal pour l'application Code Snippets
 */

class CodeSnippetsApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.highlightCode();
    }

    /**
     * Configuration des événements
     */
    setupEventListeners() {
        // Délégation d'événements pour les boutons de copie
        document.addEventListener('click', (e) => {
            if (e.target.matches('.copy-btn') || e.target.closest('.copy-btn')) {
                console.log('Bouton copie cliqué !');
                e.preventDefault();
                this.handleCopyCode(e.target.closest('.copy-btn'));
            }
        });

        // Recherche en temps réel
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(this.handleSearch.bind(this), 300));
        }

        // Filtres de catégorie
        document.addEventListener('click', (e) => {
            if (e.target.matches('.category-filter')) {
                this.handleCategoryFilter(e.target);
            }
        });
    }

    /**
     * Copie le code dans le presse-papier
     */
    async handleCopyCode(button) {
        try {
            console.log('handleCopyCode appelé', button);
            const codeContainer = button.closest('.code-container');
            console.log('Code container trouvé:', !!codeContainer);
            
            if (!codeContainer) {
                console.error('Container de code non trouvé');
                this.showCopyError(button);
                return;
            }
            
            const codeElement = codeContainer.querySelector('code');
            console.log('Code element trouvé:', !!codeElement);
            
            if (!codeElement) {
                console.error('Élément code non trouvé');
                this.showCopyError(button);
                return;
            }
            
            const text = codeElement.textContent;
            console.log('Texte à copier:', text.substring(0, 50) + '...');

            await navigator.clipboard.writeText(text);
            console.log('Copie réussie !');
            
            // Feedback visuel
            this.showCopySuccess(button);
            
        } catch (err) {
            console.error('Erreur lors de la copie:', err);
            this.showCopyError(button);
        }
    }

    /**
     * Affiche le succès de la copie
     */
    showCopySuccess(button) {
        const originalText = button.innerHTML;
        const originalClasses = button.className;
        
        button.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Copié !
        `;
        button.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
        button.classList.add('bg-green-500', 'text-white');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.className = originalClasses;
        }, 2000);
    }

    /**
     * Affiche l'erreur de copie
     */
    showCopyError(button) {
        const originalText = button.innerHTML;
        const originalClasses = button.className;
        
        button.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Erreur
        `;
        button.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
        button.classList.add('bg-red-500', 'text-white');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.className = originalClasses;
        }, 2000);
    }

    /**
     * Gère la recherche
     */
    handleSearch(e) {
        // Si on utilise maintenant le formulaire de recherche côté serveur,
        // on peut optionnellement garder cette fonction pour une recherche en temps réel
        // ou la supprimer pour éviter les conflits
        console.log('Recherche en temps réel désactivée, utilisation du formulaire côté serveur');
    }

    /**
     * Gère le filtrage par catégorie
     */
    handleCategoryFilter(button) {
        const category = button.dataset.category;
        
        // Mettre à jour l'apparence des boutons
        document.querySelectorAll('.category-filter').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        button.classList.remove('bg-gray-100', 'text-gray-700');
        button.classList.add('bg-blue-500', 'text-white');
        
        // Filtrer les cartes
        const cards = document.querySelectorAll('.snippet-card');
        cards.forEach(card => {
            const cardCategory = card.dataset.category;
            
            if (category === 'all' || cardCategory === category) {
                card.style.display = 'block';
                card.classList.add('fade-in');
            } else {
                card.style.display = 'none';
                card.classList.remove('fade-in');
            }
        });
        
        this.updateResultsCount();
        this.updateURL(category);
    }

    /**
     * Met à jour le compteur de résultats
     */
    updateResultsCount() {
        const visibleCards = document.querySelectorAll('.snippet-card[style="display: block"], .snippet-card:not([style*="display: none"])');
        const countElement = document.getElementById('results-count');
        
        if (countElement) {
            const count = visibleCards.length;
            countElement.textContent = `${count} bout${count > 1 ? 's' : ''} de code trouvé${count > 1 ? 's' : ''}`;
        }
    }

    /**
     * Met à jour l'URL sans recharger la page
     */
    updateURL(category) {
        const url = new URL(window.location);
        if (category === 'all') {
            url.searchParams.delete('category');
        } else {
            url.searchParams.set('category', category);
        }
        window.history.pushState({}, '', url);
    }

    /**
     * Coloration syntaxique
     */
    highlightCode() {
        if (window.Prism) {
            Prism.highlightAll();
        }
    }

    /**
     * Debounce utility
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
     * Affiche un toast de notification
     */
    showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Animation d'entrée
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Suppression automatique
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
}

// Initialisation de l'application
document.addEventListener('DOMContentLoaded', () => {
    new CodeSnippetsApp();
});

// Export pour utilisation dans d'autres fichiers
window.CodeSnippetsApp = CodeSnippetsApp;
