<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("ALL")
 */
class Book
{

    /**
     * @JMS\Expose()
     * @JMS\SerializedName("Id")
     */
    protected ?int $id = null;

    /**
     * @JMS\Expose()
     * @JMS\SerializedName("Name")
     */
    protected ?string $name = null;

    /**
     * @var Collection<Author>
     * @JMS\Expose()
     * @JMS\SerializedName("Author")
     */
    protected Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        $author->addBook($this);
        $this->authors[] = $author;

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }
}
