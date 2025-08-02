# 📚 CodeSnippets

Application web pour sauvegarder et partager des extraits de code.

## 🚀 Démo Live

[**Voir l'application →**](https://web-production-9ee8e.up.railway.app/)

## ✨ Ce que ça fait

- ➕ **Ajouter** des extraits de code (PHP, HTML, CSS, JS...)
- 📋 **Copier** le code en un clic  
- 🔍 **Rechercher** dans tous vos codes
- 🏷️ **Filtrer** par catégorie
- 📱 **Responsive** - fonctionne sur mobile

## 🛠️ Technologies

- **PHP 8.1** - Backend
- **PostgreSQL** - Base de données  
- **Tailwind CSS** - Interface moderne
- **Railway** - Hébergement gratuit

## 📦 Installation

```bash
# Cloner
git clone https://github.com/papesembene/-CodeSnippets.git
cd CodeSnippets

# Installer les dépendances
composer install

# Configurer la base de données
cp .env.example .env
# Éditer .env avec vos paramètres

# Lancer les migrations
php bin/migrate

# Démarrer le serveur
composer serve
```

L'app sera accessible sur http://localhost:8000

## 🌐 Déployer sur Railway

1. **Créer un compte** sur [Railway](https://railway.app)
2. **Connecter ce repository GitHub**
3. **Ajouter PostgreSQL** (+ Add Service → PostgreSQL)
4. **Déploiement automatique** ✅

## 📁 Structure

```
├── src/           # Contrôleurs et logique métier
├── templates/     # Vues HTML
├── public/        # CSS, JS et point d'entrée
├── database/      # Migrations et données
└── App/           # Framework PHP personnalisé
```

## 🤝 Contribuer

1. Fork le projet
2. Créer une branche : `git checkout -b ma-feature`
3. Commit : `git commit -m "Ajouter ma feature"`
4. Push : `git push origin ma-feature`
5. Ouvrir une Pull Request

## 👨‍💻 Auteur

**MR SEM'S**  
📧 sembenpape4@gmail.com  
🐙 [@papesembene](https://github.com/papesembene)

---

⭐ **N'hésitez pas à star le repo si ça vous plaît !**
