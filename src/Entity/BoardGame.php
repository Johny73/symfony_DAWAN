<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoardGameRepository")
 */
class BoardGame
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("today", message="Choisissez une date dans le passé")
     */
    private $releasedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThan(0, message="Définir un âge au dessus de zéro")
     */
    private $ageGroup;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="boardGames")
     */
    private $classifiedIn;

    public function __construct()
    {
        $this->classifiedIn = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeInterface
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeInterface $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getAgeGroup(): ?int
    {
        return $this->ageGroup;
    }

    public function setAgeGroup(?int $ageGroup): self
    {
        $this->ageGroup = $ageGroup;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getClassifiedIn(): Collection
    {
        return $this->classifiedIn;
    }

    public function addClassifiedIn(Category $classifiedIn): self
    {
        if (!$this->classifiedIn->contains($classifiedIn)) {
            $this->classifiedIn[] = $classifiedIn;
        }

        return $this;
    }

    public function removeClassifiedIn(Category $classifiedIn): self
    {
        if ($this->classifiedIn->contains($classifiedIn)) {
            $this->classifiedIn->removeElement($classifiedIn);
        }

        return $this;
    }
}