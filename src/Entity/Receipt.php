<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $totalCost = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $receiptAt = null;

    #[ORM\Column]
    private ?float $VAT = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getReceiptAt(): ?\DateTimeInterface
    {
        return $this->receiptAt;
    }

    public function setReceiptAt(\DateTimeInterface $receiptAt): self
    {
        $this->receiptAt = $receiptAt;

        return $this;
    }

    public function getVAT(): ?float
    {
        return $this->VAT;
    }

    public function setVAT(float $VAT): self
    {
        $this->VAT = $VAT;

        return $this;
    }
}
