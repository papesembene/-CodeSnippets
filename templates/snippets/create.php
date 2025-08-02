<?php
$title = 'Ajouter un Code Snippet';
$pageScript = 'create'; // Pour charger create.js
?>

<!-- Header de la page -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ajouter un nouveau code</h1>
            <p class="text-gray-600 mt-2">Partagez votre snippet de code avec la communauté</p>
        </div>
        <a href="/" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à l'accueil
        </a>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulaire principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <form action="/snippets/store" method="POST" id="snippetForm" class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Titre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   required 
                                   placeholder="Ex: Fonction de validation email"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Brève explication de ce que fait le code..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors resize-none"></textarea>
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors">
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat ?>"><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Code -->
                        <div>
                            <label for="code_content" class="block text-sm font-medium text-gray-700 mb-2">
                                Code <span class="text-red-500">*</span>
                            </label>
                            <textarea id="code_content" 
                                      name="code_content" 
                                      rows="15" 
                                      required 
                                      placeholder="Collez votre code ici..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors font-mono text-sm resize-none"></textarea>
                        </div>

                        <!-- Options d'aperçu -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="preview" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="preview" class="ml-2 text-sm font-medium text-gray-700">
                                    Aperçu du code avec coloration syntaxique
                                </label>
                            </div>
                        </div>

                        <!-- Aperçu du code -->
                        <div id="codePreview" class="hidden border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Aperçu :</h3>
                            <div class="code-container relative bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                <pre class="p-4 overflow-x-auto"><code id="previewCode" class="text-sm"></code></pre>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div></div>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Enregistrer le code
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar avec conseils -->
        <div class="lg:col-span-1">
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-900">Conseils</h3>
                </div>
                <ul class="space-y-3 text-sm text-blue-800">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Utilisez un titre descriptif pour retrouver facilement votre code
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        La description aide les autres à comprendre l'utilité du code
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Assurez-vous que votre code est propre et bien formaté
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Testez votre code avant de l'ajouter
                    </li>
                </ul>
            </div>

            <!-- Aperçu des catégories -->
            <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catégories disponibles</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="badge-php px-2 py-1 text-xs font-medium rounded-full">PHP</span>
                        <span class="ml-2 text-sm text-gray-600">Scripts et fonctions PHP</span>
                    </div>
                    <div class="flex items-center">
                        <span class="badge-html px-2 py-1 text-xs font-medium rounded-full">HTML</span>
                        <span class="ml-2 text-sm text-gray-600">Structures et templates HTML</span>
                    </div>
                    <div class="flex items-center">
                        <span class="badge-css px-2 py-1 text-xs font-medium rounded-full">CSS</span>
                        <span class="ml-2 text-sm text-gray-600">Styles et animations CSS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
