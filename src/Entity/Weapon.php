<?php

namespace App\Entity;

use App\Constantes\Weapon\PerkCategory;
use App\Constantes\Weapon\WeaponCategory;
use App\Constantes\Weapon\WeaponType;
use App\Entity\Challenges\CamouflageChallenge;
use App\Repository\WeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $unlock_level = null;

    #[ORM\Column(enumType: WeaponType::class)]
    private ?WeaponType $type = null;

    #[ORM\Column(enumType: WeaponCategory::class)]
    private ?WeaponCategory $category = null;

    /**
     * @var Collection<int, CamouflageChallenge>
     */
    #[ORM\OneToMany(targetEntity: CamouflageChallenge::class, mappedBy: 'weapon')]
    private Collection $camouflages;

    public function __construct()
    {
        $this->camouflages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUnlockLevel(): ?int
    {
        return $this->unlock_level;
    }

    public function setUnlockLevel(int $unlock_level): static
    {
        $this->unlock_level = $unlock_level;

        return $this;
    }

    public function getType(): ?WeaponType
    {
        return $this->type;
    }

    public function setType(WeaponType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?WeaponCategory
    {
        return $this->category;
    }

    public function setCategory(WeaponCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, CamouflageChallenge>
     */
    public function getCamouflages(): Collection
    {
        return $this->camouflages;
    }

    public function addCamouflage(CamouflageChallenge $camouflage): static
    {
        if (!$this->camouflages->contains($camouflage)) {
            $this->camouflages->add($camouflage);
            $camouflage->setWeapon($this);
        }

        return $this;
    }

    public function removeCamouflage(CamouflageChallenge $camouflage): static
    {
        if ($this->camouflages->removeElement($camouflage)) {
            // set the owning side to null (unless already changed)
            if ($camouflage->getWeapon() === $this) {
                $camouflage->setWeapon(null);
            }
        }

        return $this;
    }
}
