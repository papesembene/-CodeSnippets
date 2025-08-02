<?php

namespace App\Seeders;

use App\Core\DataBase;
use PDO;

/**
 * Seeder pour ajouter des exemples de snippets de code
 */
class CodeSnippetSeeder
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    public function run(): void
    {
        $snippets = [
            [
                'title' => 'Validation d\'email simple',
                'description' => 'Fonction PHP pour valider une adresse email avec filter_var',
                'category' => 'PHP',
                'code_content' => '<?php
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Utilisation
$email = "test@example.com";
if (validateEmail($email)) {
    echo "Email valide";
} else {
    echo "Email invalide";
}'
            ],
            [
                'title' => 'Structure HTML5 de base',
                'description' => 'Template HTML5 standard avec toutes les balises essentielles',
                'category' => 'HTML',
                'code_content' => '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description de la page">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Mon Site Web</h1>
        <nav>
            <ul>
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section id="accueil">
            <h2>Bienvenue</h2>
            <p>Contenu principal de la page.</p>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2025 Mon Site Web. Tous droits réservés.</p>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>'
            ],
            [
                'title' => 'Centrer un élément avec Flexbox',
                'description' => 'CSS pour centrer parfaitement un élément horizontalement et verticalement',
                'category' => 'CSS',
                'code_content' => '.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.centered-element {
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Alternative avec Grid */
.center-container-grid {
    display: grid;
    place-items: center;
    min-height: 100vh;
}'
            ],
            [
                'title' => 'Connexion PDO sécurisée',
                'description' => 'Classe pour gérer une connexion PDO à la base de données avec gestion d\'erreurs',
                'category' => 'PHP',
                'code_content' => '<?php
class Database {
    private $host = "localhost";
    private $dbname = "mydb";
    private $username = "user";
    private $password = "password";
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}'
            ],
            [
                'title' => 'Formulaire responsive',
                'description' => 'HTML pour un formulaire de contact responsive avec validation',
                'category' => 'HTML',
                'code_content' => '<form class="contact-form" action="/contact" method="POST">
    <div class="form-group">
        <label for="name">Nom complet *</label>
        <input type="text" id="name" name="name" required 
               placeholder="Votre nom complet">
    </div>
    
    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required 
               placeholder="votre@email.com">
    </div>
    
    <div class="form-group">
        <label for="phone">Téléphone</label>
        <input type="tel" id="phone" name="phone" 
               placeholder="06 12 34 56 78">
    </div>
    
    <div class="form-group">
        <label for="subject">Sujet *</label>
        <select id="subject" name="subject" required>
            <option value="">Choisissez un sujet</option>
            <option value="question">Question générale</option>
            <option value="support">Support technique</option>
            <option value="devis">Demande de devis</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="message">Message *</label>
        <textarea id="message" name="message" rows="5" required 
                  placeholder="Votre message..."></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn-submit">
            Envoyer le message
        </button>
    </div>
</form>'
            ],
            [
                'title' => 'Animation CSS smooth',
                'description' => 'Animations CSS fluides pour améliorer l\'expérience utilisateur',
                'category' => 'CSS',
                'code_content' => '/* Animation de fade-in */
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Bouton avec effet hover */
.btn-animated {
    padding: 12px 24px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-animated:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
}

.btn-animated:active {
    transform: translateY(0);
}

/* Loading spinner */
.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}'
            ]
        ];

        $stmt = $this->connection->prepare(
            "INSERT INTO code_snippets (title, description, category, code_content) VALUES (?, ?, ?, ?)"
        );

        foreach ($snippets as $snippet) {
            $stmt->execute([
                $snippet['title'],
                $snippet['description'],
                $snippet['category'],
                $snippet['code_content']
            ]);
        }

        echo "✅ " . count($snippets) . " snippets de code ajoutés avec succès!\n";
    }
}
