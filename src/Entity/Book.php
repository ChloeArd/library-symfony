<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide !")]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Url(message: "L'URL fournie n'est pas au bon format", protocols: ['https', 'sftp'])]
    private $picture;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L'autheur(s) ne peut pas être vide !")]
    private $author;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: "La date ne peut pas être vide !")]
    private $date;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Le résumé ne peut pas être vide !")]
    #[Assert\Length(min: 40, max: 2000, minMessage: "Résumé trop court", maxMessage: "Résumé trop long")]
    private $description;

    #[ORM\ManyToOne(targetEntity: Borrower::class, inversedBy: 'book', cascade: ['remove'])]
    #[ORM\JoinColumn(name: "borrowerID", referencedColumnName: "id", onDelete: "CASCADE", nullable: true)]
    private $borrower;

    #[ORM\Column(type: 'date', nullable: true)]
    private $reserved;

    #[ORM\Column(type: 'date', nullable: true)]
    private $recovery;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'book', cascade: ['remove'])]
    #[ORM\JoinColumn(name: "categoryID", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotBlank(message: "La catégorie ne peut pas être vide !")]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getBorrower(): ?Borrower
    {
        return $this->borrower;
    }

    public function setBorrower(?Borrower $borrower): self
    {
        $this->borrower = $borrower;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReserved() : ?\DateTime
    {
        return $this->reserved;
    }

    /**
     * @param mixed $reserved
     */
    public function setReserved(?\DateTime $reserved): self
    {
        $this->reserved = $reserved;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecovery(): ?\DateTime
    {
        return $this->recovery;
    }

    /**
     * @param mixed $recovery
     */
    public function setRecovery(?\DateTime $recovery): self
    {
        $this->recovery = $recovery;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }
}
