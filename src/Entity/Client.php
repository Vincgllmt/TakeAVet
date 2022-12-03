<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[ORM\Column]
    private ?bool $isAnHusbandry = null;

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
