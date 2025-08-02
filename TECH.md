# 🔧 Documentation Technique

Architecture et détails d'implémentation de CodeSnippets.

## 📐 Architecture

### MVC Pattern
```
Controllers/    → Logique métier (CRUD snippets)
Entities/       → Modèles de données
Repositories/   → Accès base de données
Templates/      → Vues HTML
```

### SOLID Principles
- **Single Responsibility** → Chaque classe = 1 responsabilité
- **Open/Closed** → Extensible sans modification
- **Liskov Substitution** → Interfaces respectées
- **Interface Segregation** → Interfaces spécifiques
- **Dependency Inversion** → Injection de dépendances

## 🗃️ Base de données

### Table code_snippets
```sql
CREATE TABLE code_snippets (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    code_content TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Index pour performance
```sql
CREATE INDEX idx_category ON code_snippets(category);
CREATE INDEX idx_search ON code_snippets USING GIN(to_tsvector('french', title || ' ' || description || ' ' || code_content));
```

## 🛠️ Configuration

### Variables d'environnement
```env
# Base de données
DATABASE_URL=postgresql://user:pass@host:port/db
PGHOST=localhost
PGUSER=postgres
PGPASSWORD=secret
PGDATABASE=codesnippets
PGPORT=5432

# Application
APP_ENV=production
PORT=8000
```

### Railway
- Auto-détection PHP via `composer.json`
- Build avec `nixpacks.toml`
- Variables automatiques PostgreSQL
- Déploiement via GitHub

## 🎨 Frontend

### Tailwind CSS
- Utility-first CSS framework
- Responsive design mobile-first
- Dark mode ready (pas encore activé)

### JavaScript (Vanilla ES6+)
```javascript
// Délégation d'événements
document.addEventListener('click', (e) => {
    if (e.target.matches('.copy-btn')) {
        handleCopyCode(e.target);
    }
});

// API Clipboard moderne
await navigator.clipboard.writeText(text);
```

### Prism.js
- Coloration syntaxique
- Support PHP, HTML, CSS, JS
- Thème personnalisable

## 🔄 API Interne

### Routes principales
```php
GET  /                     → Liste des snippets
GET  /snippets/show?id=X   → Détail snippet
GET  /snippets/create      → Formulaire création
POST /snippets/store       → Sauvegarder snippet
GET  /api/snippets         → API JSON (codes similaires)
```

### Format API JSON
```json
{
    "id": 1,
    "title": "Hello World PHP",
    "description": "Simple exemple",
    "code_content": "<?php echo 'Hello';",
    "category": "PHP",
    "created_at": "2025-02-08T10:00:00Z"
}
```

## 🧪 Tests

### Manuel
```bash
# Serveur local
composer serve

# Test connexion DB
php bin/migrate

# Test création snippet
curl -X POST http://localhost:8000/snippets/store
```

### Automatisé (à implémenter)
```bash
# PHPUnit tests
vendor/bin/phpunit tests/

# Tests E2E avec Playwright
npm run test:e2e
```

## 📊 Performance

### Optimisations
- Index PostgreSQL sur recherche textuelle
- Pagination (10/20/50 par page)
- Cache navigateur pour assets statiques
- Lazy loading images (si ajouté)

### Monitoring
- Logs Railway automatiques
- Health check endpoint `/`
- Métriques PostgreSQL Railway

## 🔒 Sécurité

### Mesures actuelles
- Échappement HTML (`htmlspecialchars`)
- Prepared statements PDO
- Variables d'environnement pour secrets
- HTTPS obligatoire en production Railway

### À ajouter
- [ ] Rate limiting
- [ ] CSRF protection
- [ ] Input validation plus stricte
- [ ] Authentification utilisateurs

## 🚀 Déploiement

### Checklist pré-déploiement
- [ ] Tests passent
- [ ] Variables d'environnement configurées
- [ ] Migrations DB à jour
- [ ] Assets minifiés (si applicable)

### Railway Pipeline
1. **Push GitHub** → Trigger build
2. **Nixpacks** → Détection PHP + Composer
3. **Build** → `composer install`
4. **Deploy** → `php migrate.php && php -S 0.0.0.0:$PORT -t public`
5. **Health check** → Vérification endpoint

---

**Maintenance :** Vérifier les logs Railway régulièrement et monitorer l'usage PostgreSQL.
