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

    #[ORM\OneToMany(mappedBy: 'agenda', targetEntity: Unavailability::class)]
    private Collection $unavailabilities;

    #[ORM\OneToMany(mappedBy: 'agenda', targetEntity: Vacation::class)]
    private Collection $vacations;

    #[ORM\OneToMany(mappedBy: 'agenda', targetEntity: AgendaDay::class)]
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
            $unavailability->setAgenda($this);
        }

        return $this;
    }

    public function removeUnavailability(Unavailability $unavailability): self
    {
        if ($this->unavailabilities->removeElement($unavailability)) {
            // set the owning side to null (unless already changed)
            if ($unavailability->getAgenda() === $this) {
                $unavailability->setAgenda(null);
            }
        }

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
            $vacation->setAgenda($this);
        }

        return $this;
    }

    public function removeVacation(Vacation $vacation): self
    {
        if ($this->vacations->removeElement($vacation)) {
            // set the owning side to null (unless already changed)
            if ($vacation->getAgenda() === $this) {
                $vacation->setAgenda(null);
            }
        }

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
            $day->setAgenda($this);
        }

        return $this;
    }

    public function removeDay(AgendaDay $day): self
    {
        if ($this->days->removeElement($day)) {
            // set the owning side to null (unless already changed)
            if ($day->getAgenda() === $this) {
                $day->setAgenda(null);
            }
        }

        return $this;
    }

}
