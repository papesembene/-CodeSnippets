# 📊 Système de Migrations et Seeding

## 🚀 Vue d'ensemble

L'application dispose d'un système complet de migrations et de seeding pour gérer la base de données PostgreSQL de manière professionnelle.

## 📁 Structure

```
database/
├── migrations/           # Scripts SQL de migration
│   ├── 2025_02_08_000001_create_code_snippets_table.sql
│   └── 2025_02_08_000002_add_indexes_to_code_snippets.sql
└── seeders/             # Classes PHP de seeding
    ├── CodeSnippetSeeder.php
    └── AdvancedCodeSnippetSeeder.php

bin/
├── migrate              # Script de migration
└── seed                 # Script de seeding
```

## 🔧 Commandes Composer

```bash
# Exécuter les migrations
composer database:migrate

# Exécuter les seeders
composer database:seed

# Lancer le serveur de développement
composer serve
```

## 📊 Système de Migrations

### ✨ Fonctionnalités

- **Suivi automatique** des migrations exécutées
- **Exécution ordonnée** par nom de fichier
- **Gestion d'erreurs** avec arrêt en cas de problème
- **Table `migrations`** pour tracer l'historique

### 📝 Format des Migrations

**Nom de fichier :** `YYYY_MM_DD_HHMMSS_description.sql`

**Exemple :**
```sql
-- 2025_02_08_000001_create_code_snippets_table.sql

-- Créer le type ENUM pour les catégories
CREATE TYPE category_type AS ENUM ('PHP', 'HTML', 'CSS');

-- Créer la table
CREATE TABLE IF NOT EXISTS code_snippets (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category category_type NOT NULL,
    code_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 📋 Exécution

```bash
$ composer database:migrate

🚀 Démarrage des migrations...
📡 Connexion à PostgreSQL...
✅ Connexion réussie!
📋 Vérification de la table des migrations...
✅ Table migrations OK!
🔄 Exécution de la migration: 2025_02_08_000001_create_code_snippets_table
✅ Migration réussie: 2025_02_08_000001_create_code_snippets_table
🎉 1 migration(s) exécutée(s) avec succès!
✨ Migrations terminées!
```

## 🌱 Système de Seeding

### ✨ Fonctionnalités

- **Classes PHP** pour les données complexes
- **Suivi automatique** des seeders exécutés
- **Données de test** et de développement
- **Table `seeds`** pour tracer l'historique

### 📝 Format des Seeders

**Nom de fichier :** `ClassNameSeeder.php`

**Structure :**
```php
<?php
namespace App\Seeders;

use App\Core\DataBase;
use PDO;

class ExampleSeeder
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    public function run(): void
    {
        echo "🌱 Ajout d'exemples...\n";
        
        $data = [
            ['title' => 'Test', 'category' => 'PHP', 'code' => '<?php echo "Hello"; ?>']
        ];

        $stmt = $this->connection->prepare(
            "INSERT INTO code_snippets (title, category, code_content) VALUES (?, ?, ?)"
        );

        foreach ($data as $item) {
            $stmt->execute([$item['title'], $item['category'], $item['code']]);
        }

        echo "✅ " . count($data) . " éléments ajoutés!\n";
    }
}
```

### 📋 Exécution

```bash
$ composer database:seed

🌱 Démarrage du seeding...
📡 Connexion à PostgreSQL...
✅ Connexion réussie!
📋 Vérification de la table des seeds...
✅ Table seeds OK!
🔄 Exécution du seeder: CodeSnippetSeeder
✅ 6 snippets de code ajoutés avec succès!
✅ Seeder réussi: CodeSnippetSeeder
🎉 1 seeder(s) exécuté(s) avec succès!
✨ Seeding terminé!
```

## 🏗️ Architecture des Repositories

### AbstractRepository

**Emplacement :** `App/core/abstract/AbstractRepository.php`

**Méthodes utilitaires :**
```php
// Méthodes de base
protected function fetchAll(string $sql, array $params = []): array
protected function fetchOne(string $sql, array $params = []): ?array
protected function execute(string $sql, array $params = []): bool

// Méthodes avancées
protected function count(string $table, string $where = '', array $params = []): int
protected function exists(string $table, string $where, array $params = []): bool

// Transactions
protected function beginTransaction(): bool
protected function commit(): bool
protected function rollback(): bool
```

### CodeSnippetRepository

**Utilisation optimisée :**
```php
// Avant (code répétitif)
public function findAll(): array
{
    try {
        $sql = "SELECT * FROM code_snippets ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToEntity'], $results);
    } catch (\Exception $e) {
        return [];
    }
}

// Après (utilisation d'AbstractRepository)
public function findAll(): array
{
    $sql = "SELECT * FROM code_snippets ORDER BY created_at DESC";
    $results = $this->fetchAll($sql);
    return array_map([$this, 'mapToEntity'], $results);
}
```

## 📊 Tables de Suivi

### Table `migrations`
```sql
CREATE TABLE migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL UNIQUE,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Table `seeds`
```sql
CREATE TABLE seeds (
    id SERIAL PRIMARY KEY,
    seeder VARCHAR(255) NOT NULL UNIQUE,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🎯 Workflow de Développement

### 1. **Nouvelle fonctionnalité**
```bash
# 1. Créer la migration
touch database/migrations/2025_02_08_120000_add_tags_to_snippets.sql

# 2. Exécuter la migration
composer database:migrate

# 3. Créer le seeder (optionnel)
touch database/seeders/TagSeeder.php

# 4. Exécuter le seeder
composer database:seed
```

### 2. **Développement en équipe**
```bash
# Récupérer les nouveaux fichiers
git pull

# Exécuter les nouvelles migrations
composer database:migrate

# Exécuter les nouveaux seeders
composer database:seed
```

### 3. **Déploiement en production**
```bash
# Exécuter uniquement les migrations (pas les seeders)
composer database:migrate
```

## 🔒 Sécurité et Bonnes Pratiques

### ✅ **Migrations**
- Utilisez `IF NOT EXISTS` pour éviter les erreurs
- Testez sur une copie de production
- Gardez les migrations petites et atomiques
- Documentez les changements complexes

### ✅ **Seeders**
- Séparez les données de test des données de production
- Utilisez des transactions pour l'intégrité
- Vérifiez l'existence avant insertion
- Évitez les données sensibles en dur

### ✅ **Repository**
- Utilisez les méthodes de `AbstractRepository`
- Gérez les erreurs proprement
- Respectez les types de retour
- Documentez les méthodes complexes

## 🎉 Avantages du Système

### 🚀 **Pour les Développeurs**
- Commandes simples avec Composer
- Suivi automatique des exécutions
- Code réutilisable avec AbstractRepository
- Gestion d'erreurs intégrée

### 🏢 **Pour le Projet**
- Base de données versionnée
- Déploiements reproductibles  
- Données de test cohérentes
- Architecture maintenable

Ce système offre une gestion professionnelle de la base de données adaptée aux projets modernes !
