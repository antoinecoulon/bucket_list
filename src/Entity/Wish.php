<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WishRepository::class)]
class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank(message: 'Please enter title')]
    #[Assert\Length(min: 1, max: 250,
        minMessage: 'Too short, title should be at least {{ limit }} characters',
        maxMessage: 'Too long, title should be 250 characters or less')]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(min: 1, max: 250,
        minMessage: 'Too short, description should be at least {{ limit }} characters',
        maxMessage: 'Too long, description should be 255 characters or less')]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Please enter author')]
    #[Assert\Length(min: 1, max: 50,
        minMessage: 'Too short, title should be at least {{ limit }} characters',
        maxMessage: 'Too long, title should be 50 characters or less')]
    private ?string $author = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateCreatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreatedAt(): ?\DateTimeImmutable
    {
        return $this->dateCreatedAt;
    }

    public function setDateCreatedAt(?\DateTimeImmutable $dateCreatedAt): static
    {
        $this->dateCreatedAt = $dateCreatedAt;

        return $this;
    }
}
