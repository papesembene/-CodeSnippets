<?php

namespace App\Entities;

/**
 * Entité CodeSnippet - Respecte le principe SOLID
 * Single Responsibility: Représente uniquement un snippet de code
 */
class CodeSnippet
{
    private ?int $id;
    private string $title;
    private string $description;
    private string $category;
    private string $codeContent;
    private ?\DateTime $createdAt;
    private ?\DateTime $updatedAt;

    public function __construct(
        string $title,
        string $description,
        string $category,
        string $codeContent,
        ?int $id = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->codeContent = $codeContent;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getCodeContent(): string
    {
        return $this->codeContent;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setCodeContent(string $codeContent): void
    {
        $this->codeContent = $codeContent;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'code_content' => $this->codeContent,
            'created_at' => $this->createdAt?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt?->format('Y-m-d H:i:s')
        ];
    }
}
