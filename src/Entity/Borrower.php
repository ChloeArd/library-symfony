<?php

namespace App\Entity;

use App\Repository\BorrowerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BorrowerRepository::class)]
class Borrower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide !")]
    private $firstname;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank(message: "Le nom de famille ne peut pas être vide !")]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L'email' ne peut pas être vide !")]
    #[Assert\Email(message: "L'adresse mail n'est pas au bon format !", mode: "html5")]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide !")]
    #[Assert\NotCompromisedPassword(message: "Le mot de passe est compromis, veuillez en choisir un autre !")]
    private $password;

    #[ORM\OneToMany(mappedBy: 'borrower', targetEntity: Book::class)]
    #[Assert\NotBlank(message: "Le livre ne peut pas être vide !")]
    private $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Book $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book[] = $book;
            $book->setBorrower($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBorrower() === $this) {
                $book->setBorrower(null);
            }
        }

        return $this;
    }
}
