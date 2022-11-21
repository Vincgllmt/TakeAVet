<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idAnimal = null;

    #[ORM\Column(length: 50)]
    private ?string $nomAn = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $descAn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaisAn = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imageAn = null;

    #[ORM\Column(length: 255)]
    private ?string $sexeAn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAnimal(): ?int
    {
        return $this->idAnimal;
    }

    public function setIdAnimal(int $idAnimal): self
    {
        $this->idAnimal = $idAnimal;

        return $this;
    }

    public function getNomAn(): ?string
    {
        return $this->nomAn;
    }

    public function setNomAn(string $nomAn): self
    {
        $this->nomAn = $nomAn;

        return $this;
    }

    public function getDescAn(): ?string
    {
        return $this->descAn;
    }

    public function setDescAn(?string $descAn): self
    {
        $this->descAn = $descAn;

        return $this;
    }

    public function getDateNaisAn(): ?\DateTimeInterface
    {
        return $this->dateNaisAn;
    }

    public function setDateNaisAn(\DateTimeInterface $dateNaisAn): self
    {
        $this->dateNaisAn = $dateNaisAn;

        return $this;
    }

    public function getImageAn()
    {
        return $this->imageAn;
    }

    public function setImageAn($imageAn): self
    {
        $this->imageAn = $imageAn;

        return $this;
    }

    public function getSexeAn(): ?string
    {
        return $this->sexeAn;
    }

    public function setSexeAn(string $sexeAn): self
    {
        $this->sexeAn = $sexeAn;

        return $this;
    }
}
