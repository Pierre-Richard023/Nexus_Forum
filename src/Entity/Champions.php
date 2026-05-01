<?php

namespace App\Entity;

use App\Repository\ChampionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ChampionsRepository::class)]
#[UniqueEntity(fields: ['championId'], message: 'Ce champion existe déjà.')]
class Champions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $championId = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lore = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $partype = null;

    /**
     * @var Collection<int, ChampionSpell>
     */
    #[ORM\OneToMany(targetEntity: ChampionSpell::class, mappedBy: 'champion', orphanRemoval: true)]
    private Collection $spells;

    /**
     * @var Collection<int, ChampionImage>
     */
    #[ORM\OneToMany(targetEntity: ChampionImage::class, mappedBy: 'champion', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, ChampionTag>
     */
    #[ORM\ManyToMany(targetEntity: ChampionTag::class, inversedBy: 'champions')]
    private Collection $tags;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ChampionPassive $passive = null;

    public function __construct()
    {
        $this->spells = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getChampionId(): ?string
    {
        return $this->championId;
    }

    public function setChampionId(string $championId): static
    {
        $this->championId = $championId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(?string $lore): static
    {
        $this->lore = $lore;

        return $this;
    }

    public function getPartype(): ?string
    {
        return $this->partype;
    }

    public function setPartype(?string $partype): static
    {
        $this->partype = $partype;

        return $this;
    }

    /**
     * @return Collection<int, ChampionSpell>
     */
    public function getSpells(): Collection
    {
        return $this->spells;
    }

    public function addSpell(ChampionSpell $spell): static
    {
        if (!$this->spells->contains($spell)) {
            $this->spells->add($spell);
            $spell->setChampion($this);
        }

        return $this;
    }

    public function removeSpell(ChampionSpell $spell): static
    {
        if ($this->spells->removeElement($spell)) {
            // set the owning side to null (unless already changed)
            if ($spell->getChampion() === $this) {
                $spell->setChampion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChampionImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ChampionImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setChampion($this);
        }

        return $this;
    }

    public function removeImage(ChampionImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getChampion() === $this) {
                $image->setChampion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChampionTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(ChampionTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(ChampionTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getPassive(): ?ChampionPassive
    {
        return $this->passive;
    }

    public function setPassive(?ChampionPassive $passive): static
    {
        $this->passive = $passive;

        return $this;
    }
}
