<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[ORM\Column]
    private ?bool $isAnHusbandry = null;

    #[ORM\OneToMany(mappedBy: 'ClientAnimal', targetEntity: Animal::class)]
    private Collection $animals;

    public function __construct()
    {
        parent::__construct();
        $this->animals = new ArrayCollection();
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

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setClientAnimal($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getClientAnimal() === $this) {
                $animal->setClientAnimal(null);
            }
        }

        return $this;
    }
}
