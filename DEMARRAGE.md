# 🚀 Démarrage rapide - Application Code Snippets

## 📋 Prérequis
- PHP >= 7.4
- PostgreSQL
- Extension PHP pdo_pgsql
- Serveur web (Apache/Nginx) ou utiliser le serveur PHP intégré

## ⚡ Installation rapide

### 1. Installer les dépendances
```bash
composer install
```

### 2. Configurer la base de données
Éditez le fichier [`.env`](.env) avec vos paramètres PostgreSQL :

```env
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=code_snippets_db
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
```

### 3. Configurer la base de données et les données d'exemple
```bash
php setup.php
```

### 4. Lancer l'application
```bash
php -S localhost:8000 -t public
```

### 5. Ouvrir dans le navigateur
http://localhost:8000

## 🎯 Alternative manuelle

Si le script `setup.php` ne fonctionne pas :

### 1. Créer la base de données manuellement
```sql
CREATE DATABASE code_snippets_db;
```

### 2. Exécuter la migration SQL
Connectez-vous à PostgreSQL et exécutez le contenu du fichier [`database/migrations/2025_02_08_000001_create_code_snippets_table.sql`](database/migrations/2025_02_08_000001_create_code_snippets_table.sql)

### 3. Lancer l'application
```bash
php -S localhost:8000 -t public
```

## 🎉 Utilisation

1. **Ajouter un code** : Cliquez sur "Ajouter un code"
2. **Filtrer** : Utilisez les boutons PHP, HTML, CSS sur la page d'accueil
3. **Copier** : Cliquez sur "Copier" pour copier le code
4. **Voir détail** : Cliquez sur "Voir détail" pour la vue complète

## 🐛 Résolution de problèmes

### Erreur de connexion à la base de données
- Vérifiez que PostgreSQL est démarré
- Vérifiez les paramètres dans le fichier `.env`
- Vérifiez que la base de données `code_snippets_db` existe
- Vérifiez que l'extension `pdo_pgsql` est installée (`php -m | grep pgsql`)

### Erreur "Class not found"
```bash
composer dump-autoload
```

### Erreur de permissions
```bash
chmod -R 755 .
```

## 📁 Structure des fichiers

```
public/
├── index.php             # Point d'entrée
├── assets/
│   ├── css/app.css      # Styles personnalisés
│   └── js/
│       ├── app.js       # JavaScript principal
│       └── create.js    # JS pour la création
.env                     # Variables d'environnement
App/config/env.php       # Chargeur d'environnement
App/core/DataBase.php    # Configuration BDD PostgreSQL
route/web.php            # Routes de l'application
src/controllers/         # Contrôleurs
src/entities/            # Entités
src/repositories/        # Repositories
src/services/            # Services
templates/               # Vues PHP avec Tailwind CSS
```

## 🔧 Configuration avancée

Pour un serveur de production, configurez Apache/Nginx pour pointer vers le dossier `public/` comme racine web.

## 📞 Support

En cas de problème, vérifiez :
1. Les logs d'erreur PHP
2. Les logs PostgreSQL
3. La configuration dans le fichier `.env`
4. Que l'extension `pdo_pgsql` est bien installée
