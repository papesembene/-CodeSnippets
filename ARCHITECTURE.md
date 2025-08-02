# 🏗️ Architecture de l'Application Code Snippets

## 📋 Vue d'ensemble

L'application utilise une architecture **MVC moderne** avec **SOLID design patterns** et un système de rendu propre basé sur l'**AbstractController**.

## 🎯 Architecture MVC avec AbstractController

### 📂 Structure des Contrôleurs

```php
App/core/abstract/
└── AbstractController.php    # Classe abstraite de base

src/controllers/
└── CodeSnippetController.php # Contrôleur concret
```

### 🔧 AbstractController

```php
abstract class AbstractController
{
    protected string $layout = 'main';
    
    // Méthode de rendu propre
    protected function render(string $template, array $params = []): void
    
    // Méthode de redirection
    protected function redirect(string $url): void
    
    // Méthodes abstraites obligatoires
    abstract public function index();
    abstract public function create();
    abstract public function show();
    abstract public function store();
}
```

### 🎨 Système de Templates

#### Structure des Vues
```
templates/
├── layouts/
│   └── main.php           # Layout principal avec Tailwind CSS
└── snippets/
    ├── index.php          # Page d'accueil
    ├── create.php         # Formulaire de création
    └── show.php           # Détail d'un snippet
```

#### Fonctionnement du Rendu

1. **Contrôleur** appelle `$this->render('snippets/index', $params)`
2. **AbstractController** extrait les paramètres avec `extract()`
3. **Template** est inclus et capturé avec `ob_start()`/`ob_get_clean()`
4. **Layout** est inclus avec la variable `$content` disponible

```php
// Dans le contrôleur
$this->render('snippets/index', [
    'snippets' => $snippets,
    'categories' => $categories
]);

// Dans le template snippets/index.php
<?php $title = 'Page Title'; ?>
<h1><?= $title ?></h1>
<!-- Pas besoin de ob_start/ob_get_clean -->

// Dans le layout main.php
<main><?= $content ?></main>
```

## 🏗️ Architecture SOLID

### 1. **Single Responsibility Principle (SRP)**
- `CodeSnippet` : représente uniquement un snippet
- `CodeSnippetRepository` : gère uniquement l'accès aux données
- `CodeSnippetService` : gère uniquement la logique métier
- `CodeSnippetController` : gère uniquement les requêtes HTTP

### 2. **Open/Closed Principle (OCP)**
- `AbstractController` extensible par héritage
- Nouveaux contrôleurs sans modification de l'existant

### 3. **Liskov Substitution Principle (LSP)**
- `CodeSnippetRepositoryInterface` peut être substituée
- Tout contrôleur peut remplacer `AbstractController`

### 4. **Interface Segregation Principle (ISP)**
- `CodeSnippetRepositoryInterface` : interface spécialisée
- Pas de méthodes inutiles forcées

### 5. **Dependency Inversion Principle (DIP)**
- `CodeSnippetService` dépend de l'interface, pas de l'implémentation
- Injection via le constructeur

## 📁 Structure des Assets

```
public/assets/
├── css/
│   └── app.css           # Styles personnalisés + Tailwind CSS
└── js/
    ├── app.js            # JavaScript principal (classes ES6)
    └── create.js         # JS spécifique à la création
```

### 🎨 Tailwind CSS + Styles Personnalisés
- **Tailwind CDN** pour les utilitaires
- **app.css** pour les styles spécifiques (badges, animations, etc.)
- **Classes personnalisées** : `.badge-php`, `.badge-html`, `.badge-css`

### ⚡ JavaScript Modulaire
- **Classes ES6** pour l'organisation
- **Délégation d'événements** pour les performances
- **Debouncing** pour la recherche
- **Modules séparés** par page

## 🗄️ Base de Données PostgreSQL

### 📊 Table `code_snippets`
```sql
CREATE TABLE code_snippets (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category category_type NOT NULL,  -- ENUM: PHP, HTML, CSS
    code_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 🔧 Configuration Environnement
```env
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=code_snippets_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

## 🔄 Flux de Données

### 📥 Requête Entrante
```
1. Router (route/web.php)
   ↓
2. CodeSnippetController
   ↓
3. CodeSnippetService (logique métier)
   ↓
4. CodeSnippetRepository (accès données)
   ↓
5. Database (PostgreSQL)
```

### 📤 Réponse Sortante
```
1. Repository retourne CodeSnippet entities
   ↓
2. Service applique la logique métier
   ↓
3. Controller appelle render()
   ↓
4. AbstractController charge template + layout
   ↓
5. HTML avec Tailwind CSS envoyé au client
```

## 🎯 Avantages de cette Architecture

### ✅ **Maintenabilité**
- Code organisé et séparé par responsabilités
- Templates réutilisables
- JavaScript modulaire

### ✅ **Extensibilité**
- Nouveaux contrôleurs par héritage d'`AbstractController`
- Nouveaux services facilement ajoutables
- Interface repository pour différentes implémentations

### ✅ **Testabilité**
- Injection de dépendances
- Interfaces pour le mocking
- Logique métier séparée

### ✅ **Performance**
- Assets optimisés et séparés
- JavaScript avec debouncing
- Requêtes SQL indexées

### ✅ **Sécurité**
- Variables d'environnement pour la config
- Échappement HTML automatique
- Requêtes préparées PDO

## 🚀 Démarrage Rapide

```bash
# 1. Configuration
php setup.php

# 2. Lancement
php -S localhost:8080 -t public

# 3. Test
curl http://localhost:8080
```

Cette architecture respecte les meilleures pratiques modernes tout en restant simple et compréhensible.
