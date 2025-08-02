<?php
namespace App\Core\Abstract;

abstract class AbstractController
{
    protected string $layout = 'main';
    
    public function __construct()
    {
        // Constructeur simplifié - pas de session pour cette app
    }
    
    /**
     * Rendre une vue avec des paramètres
     */
    protected function render(string $template, array $params = []): void
    {
        // Extraire les paramètres pour les rendre disponibles dans la vue
        extract($params);
        
        // Capturer le contenu de la vue
        ob_start();
        require_once __DIR__ . '/../../../templates/' . $template . '.php';
        $content = ob_get_clean();
        
        // Rendre le layout avec le contenu
        require_once __DIR__ . '/../../../templates/layouts/' . $this->layout . '.php';
    }
    
    /**
     * Redirection
     */
    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Méthodes abstraites que chaque contrôleur doit implémenter
     */
    abstract public function index();
    abstract public function create();
    abstract public function show();
    abstract public function store();
}
