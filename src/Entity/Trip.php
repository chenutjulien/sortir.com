<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepositoryback")
 */
class Trip
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
     * @ORM\Column(type="datetime")
     * @Assert\Date()
     * @Assert\NotBlank()
     * @Assert\GreaterThan("today", message="La date de sortie ne doit pas être passée")
     * )
     */
    private $startDateTime;


    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, minMessage="Ca serait plus sympa avec des gens!")
     */
    private $maxRegistration;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $informations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cancelReason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organiser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="inscriptions")
     */
    private $registereds;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\State", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spot;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date()
     * @Assert\NotBlank()
     * @Assert\GreaterThan("today", message="La date de fin de sortie ne peut pas être passée")
     */
    private $endDateTime;

    public function __construct()
    {
        $this->startDateTime= new \DateTime('now');
        $this->endDateTime= new \DateTime('now');
        $this->registereds = new ArrayCollection();
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

    public function getStartDateTime(): ?DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }


    public function getMaxRegistration(): ?int
    {
        return $this->maxRegistration;
    }

    public function setMaxRegistration(int $maxRegistration): self
    {
        $this->maxRegistration = $maxRegistration;

        return $this;
    }

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(?string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    public function getCancelReason(): ?string
    {
        return $this->cancelReason;
    }

    public function setCancelReason(?string $cancelReason): self
    {
        $this->cancelReason = $cancelReason;

        return $this;
    }

    public function getOrganiser(): ?User
    {
        return $this->organiser;
    }

    public function setOrganiser(?User $organiser): self
    {
        $this->organiser = $organiser;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRegistereds(): Collection
    {
        return $this->registereds;
    }

    public function addRegistered(User $registered): self
    {
        if (!$this->registereds->contains($registered)) {
            $this->registereds[] = $registered;
            $registered->addInscription($this);
        }

        return $this;
    }

    public function removeRegistered(User $registered): self
    {
        if ($this->registereds->contains($registered)) {
            $this->registereds->removeElement($registered);
            $registered->removeInscription($this);
        }

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }

    public function getEndDateTime(): ?DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }
}
