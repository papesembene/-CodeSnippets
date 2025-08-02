<?php

namespace App\Repositories;
use App\Core\Abstract\AbstractRepository;
use App\Core\Interfaces\CodeSnippetRepositoryInterface;
use App\Entities\CodeSnippet;
use PDO;
use DateTime;

/**
 * Repository pour les snippets de code
 * Respecte le principe de Dependency Inversion
 */
class CodeSnippetRepository extends AbstractRepository implements CodeSnippetRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(CodeSnippet $codeSnippet): bool
    {
        $sql = "INSERT INTO code_snippets (title, description, category, code_content) VALUES (?, ?, ?, ?)";
        
        return $this->execute($sql, [
            $codeSnippet->getTitle(),
            $codeSnippet->getDescription(),
            $codeSnippet->getCategory(),
            $codeSnippet->getCodeContent()
        ]);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM code_snippets ORDER BY created_at DESC";
        $results = $this->fetchAll($sql);
        
        return array_map([$this, 'mapToEntity'], $results);
    }

    public function findByCategory(string $category): array
    {
        $sql = "SELECT * FROM code_snippets WHERE category = ? ORDER BY created_at DESC";
        $results = $this->fetchAll($sql, [$category]);
        
        return array_map([$this, 'mapToEntity'], $results);
    }

    public function findById(int $id): ?CodeSnippet
    {
        $sql = "SELECT * FROM code_snippets WHERE id = ?";
        $result = $this->fetchOne($sql, [$id]);
        
        return $result ? $this->mapToEntity($result) : null;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM code_snippets WHERE id = ?";
        return $this->execute($sql, [$id]);
    }

    private function mapToEntity(array $data): CodeSnippet
    {
        return new CodeSnippet(
            $data['title'],
            $data['description'],
            $data['category'],
            $data['code_content'],
            $data['id'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at'])
        );
    }
}
