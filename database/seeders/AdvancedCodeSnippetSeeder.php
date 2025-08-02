<?php

namespace App\Seeders;

use App\Core\DataBase;
use PDO;

/**
 * Seeder avancé pour ajouter plus d'exemples de snippets
 */
class AdvancedCodeSnippetSeeder
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance()->getConnection();
    }

    public function run(): void
    {
        echo "🌱 Ajout de snippets avancés...\n";

        $snippets = [
            [
                'title' => 'Classe PDO Singleton',
                'description' => 'Implémentation du pattern Singleton pour la gestion de base de données',
                'category' => 'PHP',
                'code_content' => '<?php
class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct() {
        $dsn = "mysql:host=localhost;dbname=mydb";
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}'
            ],
            [
                'title' => 'Formulaire de contact HTML5',
                'description' => 'Formulaire complet avec validation HTML5 et accessibilité',
                'category' => 'HTML',
                'code_content' => '<form class="contact-form" method="post" action="/contact" novalidate>
    <fieldset>
        <legend>Informations personnelles</legend>
        
        <div class="form-group">
            <label for="firstname">Prénom *</label>
            <input type="text" id="firstname" name="firstname" 
                   required minlength="2" maxlength="50"
                   aria-describedby="firstname-error">
            <span id="firstname-error" class="error" role="alert"></span>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" 
                   required aria-describedby="email-error">
            <span id="email-error" class="error" role="alert"></span>
        </div>
    </fieldset>

    <fieldset>
        <legend>Message</legend>
        
        <div class="form-group">
            <label for="subject">Sujet</label>
            <select id="subject" name="subject">
                <option value="">Choisissez un sujet</option>
                <option value="info">Demande d\'information</option>
                <option value="support">Support technique</option>
            </select>
        </div>

        <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" 
                      required minlength="10" maxlength="1000"
                      aria-describedby="message-error"></textarea>
            <span id="message-error" class="error" role="alert"></span>
        </div>
    </fieldset>

    <button type="submit" class="btn-submit">Envoyer</button>
</form>'
            ],
            [
                'title' => 'Grid CSS responsive',
                'description' => 'Système de grille CSS moderne avec CSS Grid et Flexbox',
                'category' => 'CSS',
                'code_content' => '/* Conteneur principal */
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Éléments de la grille */
.grid-item {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.grid-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

/* Header de l\'item */
.grid-item-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

/* Contenu de l\'item */
.grid-item-content {
    flex: 1;
    padding: 1.5rem;
}

/* Footer de l\'item */
.grid-item-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

/* Responsive design */
@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: 1fr;
        padding: 1rem;
        gap: 1rem;
    }
}

/* Variantes de colonnes */
.grid-2-cols {
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
}

.grid-3-cols {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.grid-4-cols {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}'
            ],
            [
                'title' => 'API REST avec gestion d\'erreurs',
                'description' => 'Classe PHP pour gérer les réponses API avec codes d\'erreur appropriés',
                'category' => 'PHP',
                'code_content' => '<?php
class ApiResponse {
    private int $statusCode;
    private array $data;
    private ?string $message;

    public function __construct(int $statusCode = 200, array $data = [], ?string $message = null) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->message = $message;
    }

    public function send(): void {
        http_response_code($this->statusCode);
        header(\'Content-Type: application/json\');
        
        $response = [
            \'success\' => $this->statusCode >= 200 && $this->statusCode < 300,
            \'status_code\' => $this->statusCode,
            \'data\' => $this->data
        ];

        if ($this->message) {
            $response[\'message\'] = $this->message;
        }

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success(array $data = [], string $message = null): self {
        return new self(200, $data, $message);
    }

    public static function created(array $data = [], string $message = null): self {
        return new self(201, $data, $message);
    }

    public static function badRequest(string $message = "Requête invalide"): self {
        return new self(400, [], $message);
    }

    public static function unauthorized(string $message = "Non autorisé"): self {
        return new self(401, [], $message);
    }

    public static function forbidden(string $message = "Accès interdit"): self {
        return new self(403, [], $message);
    }

    public static function notFound(string $message = "Ressource non trouvée"): self {
        return new self(404, [], $message);
    }

    public static function serverError(string $message = "Erreur serveur"): self {
        return new self(500, [], $message);
    }
}

// Utilisation
try {
    $users = User::getAll();
    ApiResponse::success($users, "Utilisateurs récupérés")->send();
} catch (Exception $e) {
    ApiResponse::serverError("Erreur lors de la récupération")->send();
}'
            ],
            [
                'title' => 'Card component moderne',
                'description' => 'Composant card réutilisable avec variantes et états',
                'category' => 'HTML',
                'code_content' => '<!-- Card de base -->
<article class="card">
    <header class="card-header">
        <img src="image.jpg" alt="Description" class="card-image">
        <div class="card-badge">Nouveau</div>
    </header>
    
    <div class="card-content">
        <h3 class="card-title">Titre de la carte</h3>
        <p class="card-description">
            Description du contenu de la carte avec plus de détails.
        </p>
        
        <div class="card-meta">
            <time datetime="2025-02-08">8 février 2025</time>
            <span class="card-author">Par John Doe</span>
        </div>
    </div>
    
    <footer class="card-footer">
        <button class="btn btn-primary" type="button">Action principale</button>
        <button class="btn btn-secondary" type="button">Action secondaire</button>
    </footer>
</article>

<!-- Card avec icône -->
<article class="card card-icon">
    <div class="card-icon-wrapper">
        <svg class="card-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
    </div>
    
    <div class="card-content">
        <h3 class="card-title">Fonctionnalité premium</h3>
        <p class="card-description">
            Description de la fonctionnalité avec ses avantages.
        </p>
    </div>
</article>

<!-- Card horizontale -->
<article class="card card-horizontal">
    <img src="image.jpg" alt="Description" class="card-image">
    
    <div class="card-content">
        <div class="card-header">
            <h3 class="card-title">Titre horizontal</h3>
            <span class="card-status">Actif</span>
        </div>
        
        <p class="card-description">
            Cette carte utilise un layout horizontal pour afficher plus d\'informations.
        </p>
        
        <div class="card-actions">
            <button class="btn btn-sm btn-primary">Modifier</button>
            <button class="btn btn-sm btn-danger">Supprimer</button>
        </div>
    </div>
</article>'
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

        echo "✅ " . count($snippets) . " snippets avancés ajoutés avec succès!\n";
    }
}
