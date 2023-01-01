<?php

namespace App\Entity;

use App\Repository\AgendaDayRepository;
use App\Repository\AgendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\NonUniqueResultException;

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

    #[ORM\OneToOne(mappedBy: 'agenda', cascade: ['persist', 'remove'])]
    private ?Veto $veto = null;

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

    public function getVeto(): ?Veto
    {
        return $this->veto;
    }

    public function setVeto(?Veto $veto): self
    {
        // unset the owning side of the relation if necessary
        if (null === $veto && null !== $this->veto) {
            $this->veto->setAgenda(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $veto && $veto->getAgenda() !== $this) {
            $veto->setAgenda($this);
        }

        $this->veto = $veto;

        return $this;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function canTakeAt(\DateTime $dateTime, AgendaDayRepository $agendaDayRepository, TypeAppointment $appointmentType): bool
    {
        $dayNumber = date('w', $dateTime) + 1;

        // null: Vet is not working this day or $dateTime is not valid, not null: OK
        $agendaDay = $agendaDayRepository->findAt($dayNumber, $this, $dateTime);
        $isDateValidWithDays = null !== $agendaDay;

        // TODO: canTakeAt
        return $isDateValidWithDays;
    }
}
