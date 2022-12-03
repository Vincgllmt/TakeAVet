<?php

namespace App\Entity;

use App\Repository\VetoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VetoRepository::class)]
class Veto extends User
{
}
