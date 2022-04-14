<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']]
)]

class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("read")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("read")]
    private $name;

    #[ORM\Column(type: 'datetime')]
    #[Groups("read")]
    private $startingDate;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("read")]
    private $duration;

    #[ORM\Column(type: 'datetime')]
    #[Groups("read")]
    private $limitInscribeDate;

    #[ORM\Column(type: 'integer')]
    #[Groups("read")]
    private $maxInscriptionsNumber;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("read")]
    private $informations;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("read")]
    private $organisator;

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'events')]
    #[Groups("read")]
    private $campus;

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'eventsRegistrations')]
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
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

    public function getOrganisator(): ?User
    {
        return $this->organisator;
    }

    public function setOrganisator(?User $organisator): self
    {
        $this->organisator = $organisator;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
