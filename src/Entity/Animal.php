<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $race = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $photo = null;

    #[ORM\Column]
    private ?bool $isDomestic = null;

    #[ORM\ManyToMany(targetEntity: Vaccine::class)]
    private Collection $vaccines;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?AnimalRecord $record = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryAnimal $category = null;

    public function __construct()
    {
        $this->vaccines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(?string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function isIsDomestic(): ?bool
    {
        return $this->isDomestic;
    }

    public function setIsDomestic(bool $isDomestic): self
    {
        $this->isDomestic = $isDomestic;

        return $this;
    }

    /**
     * @return Collection<int, Vaccine>
     */
    public function getVaccines(): Collection
    {
        return $this->vaccines;
    }

    public function addVaccine(Vaccine $vaccine): self
    {
        if (!$this->vaccines->contains($vaccine)) {
            $this->vaccines->add($vaccine);
        }

        return $this;
    }

    public function removeVaccine(Vaccine $vaccine): self
    {
        $this->vaccines->removeElement($vaccine);

        return $this;
    }

    public function getRecord(): ?AnimalRecord
    {
        return $this->record;
    }

    public function setRecord(?AnimalRecord $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getCategory(): ?CategoryAnimal
    {
        return $this->category;
    }

    public function setCategory(?CategoryAnimal $category): self
    {
        $this->category = $category;

        return $this;
    }
}
