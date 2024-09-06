<?php

namespace App\Entity;

use App\Entity\Challenges\CampaignChallenge;
use App\Repository\CampaignMissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignMissionRepository::class)]
class CampaignMission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?bool $bonus_mission = null;

    /**
     * @var Collection<int, Map>
     */
    #[ORM\ManyToMany(targetEntity: Map::class, inversedBy: 'campaignMissions')]
    private Collection $related_maps;

    /**
     * @var Collection<int, CampaignChallenge>
     */
    #[ORM\OneToMany(targetEntity: CampaignChallenge::class, mappedBy: 'campaign_mission')]
    private Collection $campaigns;

    public function __construct()
    {
        $this->related_maps = new ArrayCollection();
        $this->campaigns = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function isBonusMission(): ?bool
    {
        return $this->bonus_mission;
    }

    public function setBonusMission(bool $bonus_mission): static
    {
        $this->bonus_mission = $bonus_mission;

        return $this;
    }

    /**
     * @return Collection<int, Map>
     */
    public function getRelatedMaps(): Collection
    {
        return $this->related_maps;
    }

    public function addRelatedMap(Map $relatedMap): static
    {
        if (!$this->related_maps->contains($relatedMap)) {
            $this->related_maps->add($relatedMap);
        }

        return $this;
    }

    public function removeRelatedMap(Map $relatedMap): static
    {
        $this->related_maps->removeElement($relatedMap);

        return $this;
    }

    /**
     * @return Collection<int, CampaignChallenge>
     */
    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }

    public function addCampaign(CampaignChallenge $campaign): static
    {
        if (!$this->campaigns->contains($campaign)) {
            $this->campaigns->add($campaign);
            $campaign->setCampaignMission($this);
        }

        return $this;
    }

    public function removeCampaign(CampaignChallenge $campaign): static
    {
        if ($this->campaigns->removeElement($campaign)) {
            // set the owning side to null (unless already changed)
            if ($campaign->getCampaignMission() === $this) {
                $campaign->setCampaignMission(null);
            }
        }

        return $this;
    }
}
