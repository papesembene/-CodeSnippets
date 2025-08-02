<?php

namespace App\Core\Interfaces;

use App\Entities\CodeSnippet;

/**
 * Interface pour le repository des snippets de code
 * Respecte l'Interface Segregation Principle
 */
interface CodeSnippetRepositoryInterface
{
    public function save(CodeSnippet $codeSnippet): bool;
    public function findAll(): array;
    public function findByCategory(string $category): array;
    public function findById(int $id): ?CodeSnippet;
    public function delete(int $id): bool;
}
