<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateApp = null;

    #[ORM\Column]
    private ?bool $isUrgent = null;

    #[ORM\Column]
    private ?bool $isCompleted = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $note = null;

    #[ORM\OneToOne(inversedBy: 'appointment', cascade: ['persist', 'remove'])]
    private ?Receipt $receipt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeAppointment $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateApp(): ?\DateTimeInterface
    {
        return $this->dateApp;
    }

    public function setDateApp(\DateTimeInterface $dateApp): self
    {
        $this->dateApp = $dateApp;

        return $this;
    }

    public function isIsUrgent(): ?bool
    {
        return $this->isUrgent;
    }

    public function setIsUrgent(bool $isUrgent): self
    {
        $this->isUrgent = $isUrgent;

        return $this;
    }

    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    public function setReceipt(?Receipt $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getType(): ?TypeAppointment
    {
        return $this->type;
    }

    public function setType(?TypeAppointment $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
