<?php

namespace App\Entity;


class Filter
{

    private $id;


    private $Site;


    private $Search;


    private $debDate;


    private $endDateTime;


    private $organiser;


    private $registered;


    private $unregistered;


    private $pastTrip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSite(): ?Site
    {
        return $this->Site;
    }

    public function setSite(?Site $Site): self
    {
        $this->Site = $Site;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->Search;
    }

    public function setSearch(?string $Search): self
    {
        $this->Search = $Search;

        return $this;
    }

    public function getDebDate(): ?\DateTimeInterface
    {
        return $this->debDate;
    }

    public function setDebDate(?\DateTimeInterface $debDate): self
    {
        $this->debDate = $debDate;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getOrganiser(): ?bool
    {
        return $this->organiser;
    }

    public function setOrganiser(?bool $organiser): self
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function getRegistered(): ?bool
    {
        return $this->registered;
    }

    public function setRegistered(?bool $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    public function getUnregistered(): ?bool
    {
        return $this->unregistered;
    }

    public function setUnregistered(?bool $unregistered): self
    {
        $this->unregistered = $unregistered;

        return $this;
    }

    public function getPastTrip(): ?bool
    {
        return $this->pastTrip;
    }

    public function setPastTrip(?bool $pastTrip): self
    {
        $this->pastTrip = $pastTrip;

        return $this;
    }
}
