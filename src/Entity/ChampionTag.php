<?php

namespace App\Entity;

use App\Repository\ChampionTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ChampionTagRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'Ce tag existe déjà.')]
class ChampionTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Champions>
     */
    #[ORM\ManyToMany(targetEntity: Champions::class, mappedBy: 'tags')]
    private Collection $champions;

    public function __construct()
    {
        $this->champions = new ArrayCollection();
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

    /**
     * @return Collection<int, Champions>
     */
    public function getChampions(): Collection
    {
        return $this->champions;
    }

    public function addChampion(Champions $champion): static
    {
        if (!$this->champions->contains($champion)) {
            $this->champions->add($champion);
            $champion->addTag($this);
        }

        return $this;
    }

    public function removeChampion(Champions $champion): static
    {
        if ($this->champions->removeElement($champion)) {
            $champion->removeTag($this);
        }

        return $this;
    }
}
