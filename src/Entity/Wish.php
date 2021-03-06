<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WishRepository::class)
 */
class Wish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a name of the wish !!")
     * @Assert\Length(
     *     max=250, maxMessage="Max 250 caracters please !!",
     *     min=2,   minMessage="Min 2 caracters please !!"
     * )
     * @ORM\Column(type="string", length=250)
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Please provide a description of the wish !!")
     * @Assert\Length(
     *     max=2000, maxMessage="Max 2000 caracters please !!",
     *     min=2,   minMessage="Min 2 caracters please !!"
     * )
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Please provide a author of the wish !!")
     * @Assert\Length(
     *     max=50, maxMessage="Max 50 caracters please !!",
     *     min=2,   minMessage="Min 2 caracters please !!"
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @Assert\Range(
     *     min="0", max="10",
     *     notInRangeMessage="Vote must be between 0 and 10"
     * )
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $vote;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="wishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getVote(): ?float
    {
        return $this->vote;
    }

    public function setVote(?float $vote): self
    {
        $this->vote = $vote;

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
