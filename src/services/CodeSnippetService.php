<?php

namespace App\Services;

use App\Core\Interfaces\CodeSnippetRepositoryInterface;
use App\Entities\CodeSnippet;

/**
 * Service pour gérer la logique métier des snippets de code
 * Respecte le principe Single Responsibility
 */
class CodeSnippetService
{
    private CodeSnippetRepositoryInterface $repository;

    public function __construct(CodeSnippetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCodeSnippet(string $title, string $description, string $category, string $codeContent): bool
    {
        // Validation des données
        if (empty($title) || empty($codeContent)) {
            return false;
        }

        if (!in_array($category, ['PHP', 'HTML', 'CSS'])) {
            return false;
        }

        $codeSnippet = new CodeSnippet($title, $description, $category, $codeContent);
        return $this->repository->save($codeSnippet);
    }

    public function getAllCodeSnippets(): array
    {
        return $this->repository->findAll();
    }

    public function getCodeSnippetsByCategory(string $category): array
    {
        if (!in_array($category, ['PHP', 'HTML', 'CSS'])) {
            return [];
        }

        return $this->repository->findByCategory($category);
    }

    public function getCodeSnippetById(int $id): ?CodeSnippet
    {
        return $this->repository->findById($id);
    }

    public function deleteCodeSnippet(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getAvailableCategories(): array
    {
        return ['PHP', 'HTML', 'CSS'];
    }
}
