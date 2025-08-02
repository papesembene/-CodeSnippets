# 📚 CodeSnippets - Bibliothèque de Codes

Une application web moderne pour gérer et partager des extraits de code. Construite avec un framework PHP personnalisé.

![Screenshot](https://via.placeholder.com/800x400?text=CodeSnippets+App)

## ✨ Fonctionnalités

- 📝 **Gestion de snippets** - Créer, modifier, supprimer des extraits de code
- 🔍 **Recherche avancée** - Par titre, description ou contenu
- 🏷️ **Catégorisation** - PHP, HTML, CSS, JavaScript, etc.
- 📋 **Copie en un clic** - Boutons de copie avec feedback visuel
- 🖥️ **Mode plein écran** - Visualisation optimisée du code
- 📱 **Design responsive** - Interface moderne avec Tailwind CSS
- 🔄 **Pagination** - Navigation fluide des résultats

## 🚀 Démo Live

[**Voir l'application en action →**](https://your-app.railway.app)

## 🛠️ Technologies

- **Backend**: PHP 8.1+, Framework personnalisé
- **Frontend**: Tailwind CSS, JavaScript (ES6+)
- **Base de données**: PostgreSQL/MySQL
- **Déploiement**: Railway
- **Coloration syntaxique**: Prism.js

## 📦 Installation Locale

```bash
# Cloner le repository
git clone https://github.com/yourusername/codesnippets.git
cd codesnippets

# Installer les dépendances
composer install

# Configurer l'environnement
cp .env.example .env
# Éditer .env avec vos paramètres de DB

# Migrations
php bin/migrate

# Démarrer le serveur
composer serve
```

## 🌐 Déploiement sur Railway

1. **Créer un compte** sur [Railway](https://railway.app)
2. **Connecter GitHub** et sélectionner ce repository
3. **Ajouter PostgreSQL** dans Railway
4. **Variables d'environnement** seront configurées automatiquement
5. **Déploiement automatique** à chaque push

## 📁 Structure du Projet

```
├── App/                # Framework personnalisé
├── src/                # Code de l'application
│   ├── controllers/    # Contrôleurs
│   ├── entities/       # Entités/Modèles
│   └── repositories/   # Accès aux données
├── templates/          # Vues et layouts
├── public/             # Assets (CSS, JS, images)
├── database/           # Migrations et seeders
└── route/              # Configuration des routes
```

## 🎨 Screenshots

| Page d'accueil | Détail du snippet |
|----------------|-------------------|
| ![Home](https://via.placeholder.com/400x250) | ![Detail](https://via.placeholder.com/400x250) |

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/amazing-feature`)
3. Commit vos changements (`git commit -m 'Add amazing feature'`)
4. Push la branche (`git push origin feature/amazing-feature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👨‍💻 Auteur

**MR SEM'S**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: sembenpape4@gmail.com

---

⭐ **Star ce repo** si vous l'avez trouvé utile !
