<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $startingDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $duration;

    #[ORM\Column(type: 'datetime')]
    private $limitInscribeDate;

    #[ORM\Column(type: 'integer')]
    private $maxInscriptionsNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private $informations;

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

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getLimitInscribeDate(): ?\DateTimeInterface
    {
        return $this->limitInscribeDate;
    }

    public function setLimitInscribeDate(\DateTimeInterface $limitInscribeDate): self
    {
        $this->limitInscribeDate = $limitInscribeDate;

        return $this;
    }

    public function getMaxInscriptionsNumber(): ?int
    {
        return $this->maxInscriptionsNumber;
    }

    public function setMaxInscriptionsNumber(int $maxInscriptionsNumber): self
    {
        $this->maxInscriptionsNumber = $maxInscriptionsNumber;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }
}
