<?php

namespace App\Entity;

use App\Repository\AnimalRecordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRecordRepository::class)]
class AnimalRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?float $height = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $otherInfos = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $healthInfos = null;

    #[ORM\ManyToOne(inversedBy: 'animalRecords')]
    private ?Animal $Avoir = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRecord = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getOtherInfos(): ?string
    {
        return $this->otherInfos;
    }

    public function setOtherInfos(?string $otherInfos): self
    {
        $this->otherInfos = $otherInfos;

        return $this;
    }

    public function getHealthInfos(): ?string
    {
        return $this->healthInfos;
    }

    public function setHealthInfos(?string $healthInfos): self
    {
        $this->healthInfos = $healthInfos;

        return $this;
    }

    public function getAvoir(): ?Animal
    {
        return $this->Avoir;
    }

    public function setAvoir(?Animal $Avoir): self
    {
        $this->Avoir = $Avoir;

        return $this;
    }

    public function getDateRecord(): ?\DateTimeInterface
    {
        return $this->dateRecord;
    }

    public function setDateRecord(\DateTimeInterface $dateRecord): self
    {
        $this->dateRecord = $dateRecord;

        return $this;
    }
}
