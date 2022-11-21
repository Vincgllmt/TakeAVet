<?php

namespace App\Entity;

use App\Repository\TypeAnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAnimalRepository::class)]
class TypeAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idTpAnimal = null;

    #[ORM\Column(length: 50)]
    private ?string $libTpAnimal = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $raceAnimal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTpAnimal(): ?int
    {
        return $this->idTpAnimal;
    }

    public function setIdTpAnimal(int $idTpAnimal): self
    {
        $this->idTpAnimal = $idTpAnimal;

        return $this;
    }

    public function getLibTpAnimal(): ?string
    {
        return $this->libTpAnimal;
    }

    public function setLibTpAnimal(string $libTpAnimal): self
    {
        $this->libTpAnimal = $libTpAnimal;

        return $this;
    }

    public function getRaceAnimal(): ?string
    {
        return $this->raceAnimal;
    }

    public function setRaceAnimal(?string $raceAnimal): self
    {
        $this->raceAnimal = $raceAnimal;

        return $this;
    }
}
