<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
class Agenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Unavailability::class)]
    private Collection $unavailabilities;

    #[ORM\ManyToMany(targetEntity: Vacation::class)]
    private Collection $vacations;

    #[ORM\ManyToMany(targetEntity: AgendaDay::class)]
    private Collection $days;

    public function __construct()
    {
        $this->unavailabilities = new ArrayCollection();
        $this->vacations = new ArrayCollection();
        $this->days = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Unavailability>
     */
    public function getUnavailabilities(): Collection
    {
        return $this->unavailabilities;
    }

    public function addUnavailability(Unavailability $unavailability): self
    {
        if (!$this->unavailabilities->contains($unavailability)) {
            $this->unavailabilities->add($unavailability);
        }

        return $this;
    }

    public function removeUnavailability(Unavailability $unavailability): self
    {
        $this->unavailabilities->removeElement($unavailability);

        return $this;
    }

    /**
     * @return Collection<int, Vacation>
     */
    public function getVacations(): Collection
    {
        return $this->vacations;
    }

    public function addVacation(Vacation $vacation): self
    {
        if (!$this->vacations->contains($vacation)) {
            $this->vacations->add($vacation);
        }

        return $this;
    }

    public function removeVacation(Vacation $vacation): self
    {
        $this->vacations->removeElement($vacation);

        return $this;
    }

    /**
     * @return Collection<int, AgendaDay>
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(AgendaDay $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
        }

        return $this;
    }

    public function removeDay(AgendaDay $day): self
    {
        $this->days->removeElement($day);

        return $this;
    }
}
