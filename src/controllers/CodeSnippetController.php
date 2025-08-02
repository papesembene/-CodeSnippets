<?php

namespace App\Controllers;

use App\Services\CodeSnippetService;
use App\Repositories\CodeSnippetRepository;
use App\Core\Abstract\AbstractController;
use App\Entities\CodeSnippet;
use App\Paginator\Paginator;


/**
 * Contrôleur pour les snippets de code
 * Respecte le principe Open/Closed et Single Responsibility
 */
class CodeSnippetController extends AbstractController
{
    private CodeSnippetService $codeSnippetService;

    public function __construct()
    {
        parent::__construct();
        $repository = new CodeSnippetRepository();
        $this->codeSnippetService = new CodeSnippetService($repository);
    }

    public function index(): void
    {
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? '';
        $itemsPerPage = (int)($_GET['per_page'] ?? 10);
        
        // Récupérer tous les snippets selon les filtres
        if ($category && $category !== 'all') {
            $allSnippets = $this->codeSnippetService->getCodeSnippetsByCategory($category);
        } else {
            $allSnippets = $this->codeSnippetService->getAllCodeSnippets();
        }

        // Filtrer par recherche si nécessaire
        if (!empty($search)) {
            $allSnippets = array_filter($allSnippets, function($snippet) use ($search) {
                $searchLower = strtolower($search);
                return strpos(strtolower($snippet->getTitle()), $searchLower) !== false ||
                       strpos(strtolower($snippet->getDescription() ?? ''), $searchLower) !== false ||
                       strpos(strtolower($snippet->getCodeContent()), $searchLower) !== false;
            });
        }

        // Appliquer la pagination
        $paginatedData = Paginator::paginate(array_values($allSnippets), $itemsPerPage);
        
        $categories = $this->codeSnippetService->getAvailableCategories();
        
        $this->render('snippets/index', [
            'snippets' => $paginatedData['items'],
            'categories' => $categories,
            'selectedCategory' => $category,
            'search' => $search,
            'pagination' => $paginatedData,
            'totalResults' => count($allSnippets)
        ]);
    }

    public function create(): void
    {
        $categories = $this->codeSnippetService->getAvailableCategories();
        // require_once __DIR__ . '/../../templates/snippets/create.php';
        $this->render('snippets/create', [
            'categories' => $categories
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/snippets/create');
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $codeContent = $_POST['code_content'] ?? '';

        if ($this->codeSnippetService->createCodeSnippet($title, $description, $category, $codeContent)) {
            $this->redirect('/?success=1');
        } else {
            $this->redirect('/snippets/create?error=1');
        }
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->redirect('/');
        }

        $snippet = $this->codeSnippetService->getCodeSnippetById((int)$id);
        
        if (!$snippet) {
            $this->redirect('/?error=not_found');
        }

        $this->render('snippets/show', [
            'snippet' => $snippet
        ]);
    }

    public function api(): void
    {
        header('Content-Type: application/json');
        
        $category = $_GET['category'] ?? null;
        
        if ($category) {
            $snippets = $this->codeSnippetService->getCodeSnippetsByCategory($category);
        } else {
            $snippets = $this->codeSnippetService->getAllCodeSnippets();
        }

        $data = array_map(fn($snippet) => $snippet->toArray(), $snippets);
        echo json_encode($data);
    }
}
