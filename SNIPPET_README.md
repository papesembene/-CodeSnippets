# 📝 Application Code Snippets

Une application web simple permettant d'enregistrer et consulter des bouts de code sans authentification.

## ✨ Fonctionnalités

### ✅ Ajout d'un bout de code
- **Titre** : nom descriptif du snippet
- **Description** : explication de ce que fait le code
- **Catégorie** : PHP, HTML ou CSS
- **Code** : le code source complet
- Aperçu en temps réel avec coloration syntaxique

### ✅ Consultation des codes
- Liste complète des snippets avec titre, description et catégorie
- Fonctionnalité de copie en un clic
- Page de détail pour chaque snippet
- Codes similaires suggérés

### ✅ Filtrage par catégorie
- Boutons de filtrage sur la page d'accueil
- Statistiques par catégorie
- Navigation facile entre les catégories

### ✅ Interface utilisateur
- Design responsive avec Bootstrap
- Coloration syntaxique avec Prism.js
- Mode plein écran pour les codes
- Messages de feedback utilisateur

## 🛠️ Technologies utilisées

### Backend PHP (SOLID Design Patterns)
- **Single Responsibility** : Chaque classe a une responsabilité unique
- **Open/Closed** : Extensions possibles sans modification
- **Liskov Substitution** : Interfaces respectées
- **Interface Segregation** : Interfaces spécifiques
- **Dependency Inversion** : Dépendances inversées

### Frontend JavaScript
- Copie de code dans le presse-papier
- Filtrage dynamique
- Aperçu en temps réel
- Interactions utilisateur fluides

### Base de données MySQL
```sql
code_snippets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('PHP', 'HTML', 'CSS') NOT NULL,
    code_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

## 🏗️ Architecture

```
src/
├── controllers/     # Contrôleurs (gestion des requêtes)
├── entities/        # Entités métier (CodeSnippet)
├── repositories/    # Accès aux données (Repository Pattern)
└── services/        # Logique métier (Business Logic)

App/core/Interface/  # Interfaces (Dependency Inversion)
templates/           # Vues PHP
├── layouts/         # Layout principal
└── snippets/        # Vues spécifiques

database/
├── migrations/      # Scripts de création de tables
└── seeders/         # Données d'exemple

route/               # Configuration des routes
├── web.php          # Routes web
└── api.php          # Routes API
```

## 🚀 Installation et utilisation

### Prérequis
- PHP >= 7.4
- MySQL
- Composer

### Installation
1. **Cloner le projet**
```bash
git clone [repository]
cd ChallengeProject
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**
Modifier les paramètres dans `App/core/DataBase.php`

4. **Configurer l'application**
```bash
php bin/setup
```

5. **Lancer le serveur**
```bash
composer serve
```

6. **Accéder à l'application**
Ouvrir http://localhost:8000

## 📱 Utilisation

### Ajouter un code snippet
1. Cliquer sur "Ajouter un code"
2. Remplir le formulaire :
   - Titre (obligatoire)
   - Description (optionnelle)
   - Catégorie (PHP/HTML/CSS)
   - Code source (obligatoire)
3. Utiliser l'aperçu pour vérifier
4. Enregistrer

### Consulter les snippets
1. Page d'accueil : voir tous les snippets
2. Filtrer par catégorie avec les boutons
3. Copier un code en cliquant sur "Copier"
4. Voir le détail en cliquant sur "Voir détail"

### Navigation
- **Accueil** : liste de tous les snippets
- **Filtrage** : par catégorie PHP, HTML, CSS
- **Détail** : vue complète d'un snippet
- **Création** : formulaire d'ajout

## 🎯 Principe SOLID appliqué

### Single Responsibility Principle (SRP)
- `CodeSnippet` : représente uniquement un snippet
- `CodeSnippetRepository` : gère uniquement l'accès aux données
- `CodeSnippetService` : gère uniquement la logique métier
- `CodeSnippetController` : gère uniquement les requêtes HTTP

### Open/Closed Principle (OCP)
- Extensible par héritage et composition
- Fermé aux modifications grâce aux abstractions

### Liskov Substitution Principle (LSP)
- `CodeSnippetRepositoryInterface` peut être substituée
- Implémentations interchangeables

### Interface Segregation Principle (ISP)
- Interface spécifique `CodeSnippetRepositoryInterface`
- Pas de méthodes inutiles forcées

### Dependency Inversion Principle (DIP)
- `CodeSnippetService` dépend de l'interface, pas de l'implémentation
- Inversion des dépendances via l'injection

## 📊 Exemples de données

L'application est livrée avec 6 exemples de snippets :
- 2 snippets PHP (validation email, connexion PDO)
- 2 snippets HTML (structure de base, formulaire)
- 2 snippets CSS (centrage flexbox, animations)

## 🔧 Maintenance

### Ajouter une nouvelle catégorie
1. Modifier l'ENUM dans la migration
2. Mettre à jour `CodeSnippetService::getAvailableCategories()`
3. Ajouter la couleur de badge dans les templates

### Ajouter de nouveaux champs
1. Modifier la table avec une migration
2. Mettre à jour l'entité `CodeSnippet`
3. Adapter le repository et le service
4. Modifier les templates

## 🎨 Design

- **Bootstrap 5** pour le responsive design
- **Prism.js** pour la coloration syntaxique
- **Interface intuitive** avec icônes et feedback
- **Couleurs par catégorie** pour l'identification rapide

## 🔒 Sécurité

- **Échappement HTML** pour éviter les failles XSS
- **Requêtes préparées** PDO contre l'injection SQL
- **Validation des données** côté serveur
- **Pas d'authentification** comme demandé

## 📈 Performance

- **Index sur les colonnes** de recherche fréquente
- **Limitation des résultats** pour éviter la surcharge
- **Cache navigateur** pour les ressources statiques

## 🎉 Conclusion

Cette application respecte à la lettre le cahier des charges :
- ✅ Ajout de snippets avec formulaire complet
- ✅ Consultation avec liste et détail
- ✅ Filtrage par catégorie
- ✅ Copie de code en JavaScript
- ✅ Sans authentification
- ✅ Base de données MySQL
- ✅ Backend PHP avec SOLID
- ✅ Frontend JavaScript

L'architecture SOLID permet une maintenabilité et une extensibilité optimales.
