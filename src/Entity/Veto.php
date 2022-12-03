<?php

namespace App\Entity;

use App\Repository\VetoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VetoRepository::class)]
class Veto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isAnHusbandry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsAnHusbandry(): ?bool
    {
        return $this->isAnHusbandry;
    }

    public function setIsAnHusbandry(bool $isAnHusbandry): self
    {
        $this->isAnHusbandry = $isAnHusbandry;

        return $this;
    }
}
