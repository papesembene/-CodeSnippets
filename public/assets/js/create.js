/**
 * JavaScript pour la page de création de snippets
 */

class SnippetCreator {
    constructor() {
        this.form = document.getElementById('snippetForm');
        this.preview = document.getElementById('codePreview');
        this.previewCode = document.getElementById('previewCode');
        this.codeContent = document.getElementById('code_content');
        this.category = document.getElementById('category');
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupAutoResize();
    }

    setupEventListeners() {
        // Toggle aperçu
        const previewToggle = document.getElementById('preview');
        if (previewToggle) {
            previewToggle.addEventListener('change', this.togglePreview.bind(this));
        }

        // Mise à jour en temps réel de l'aperçu
        if (this.codeContent) {
            this.codeContent.addEventListener('input', this.updatePreview.bind(this));
        }

        if (this.category) {
            this.category.addEventListener('change', this.updatePreview.bind(this));
        }

        // Validation du formulaire
        if (this.form) {
            this.form.addEventListener('submit', this.validateForm.bind(this));
        }
    }

    togglePreview() {
        const previewToggle = document.getElementById('preview');
        if (previewToggle.checked) {
            this.preview.classList.remove('hidden');
            this.updatePreview();
        } else {
            this.preview.classList.add('hidden');
        }
    }

    updatePreview() {
        if (!this.previewCode || !this.codeContent) return;

        const code = this.codeContent.value;
        const category = this.category.value;
        
        this.previewCode.textContent = code;
        
        // Mise à jour de la classe pour la coloration syntaxique
        this.previewCode.className = category ? `language-${category.toLowerCase()}` : '';
        
        // Re-coloriser le code avec Prism
        if (window.Prism) {
            Prism.highlightElement(this.previewCode);
        }
    }

    setupFormValidation() {
        if (!this.form) return;

        // Validation en temps réel
        const inputs = this.form.querySelectorAll('input[required], textarea[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';

        // Validation selon le type de champ
        switch (field.name) {
            case 'title':
                if (!value) {
                    isValid = false;
                    message = 'Le titre est obligatoire';
                } else if (value.length < 3) {
                    isValid = false;
                    message = 'Le titre doit contenir au moins 3 caractères';
                }
                break;

            case 'category':
                if (!value) {
                    isValid = false;
                    message = 'Veuillez sélectionner une catégorie';
                }
                break;

            case 'code_content':
                if (!value) {
                    isValid = false;
                    message = 'Le code est obligatoire';
                } else if (value.length < 10) {
                    isValid = false;
                    message = 'Le code doit contenir au moins 10 caractères';
                }
                break;
        }

        this.showFieldValidation(field, isValid, message);
        return isValid;
    }

    showFieldValidation(field, isValid, message) {
        // Supprimer les anciennes classes et messages
        this.clearFieldError(field);

        if (!isValid) {
            field.classList.add('border-red-500', 'bg-red-50');
            
            // Créer le message d'erreur
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-1';
            errorDiv.textContent = message;
            errorDiv.id = `error-${field.name}`;
            
            field.parentNode.appendChild(errorDiv);
        } else {
            field.classList.add('border-green-500', 'bg-green-50');
        }
    }

    clearFieldError(field) {
        field.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
        
        const errorElement = document.getElementById(`error-${field.name}`);
        if (errorElement) {
            errorElement.remove();
        }
    }

    validateForm(e) {
        let isFormValid = true;
        
        // Valider tous les champs requis
        const requiredFields = this.form.querySelectorAll('input[required], textarea[required], select[required]');
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();
            this.showFormError('Veuillez corriger les erreurs avant de soumettre le formulaire.');
            return false;
        }

        // Afficher un loader
        this.showSubmitLoader();
        return true;
    }

    showFormError(message) {
        // Supprimer l'ancien message d'erreur
        const oldError = document.getElementById('form-error');
        if (oldError) {
            oldError.remove();
        }

        // Créer le nouveau message
        const errorDiv = document.createElement('div');
        errorDiv.id = 'form-error';
        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
        errorDiv.textContent = message;

        this.form.insertBefore(errorDiv, this.form.firstChild);
    }

    showSubmitLoader() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enregistrement...
            `;
            submitBtn.disabled = true;
        }
    }

    setupAutoResize() {
        if (!this.codeContent) return;

        this.codeContent.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    new SnippetCreator();
});
