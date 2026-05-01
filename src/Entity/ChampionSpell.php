<?php

namespace App\Entity;

use App\Repository\ChampionSpellRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;


#[ORM\Entity(repositoryClass: ChampionSpellRepository::class)]
#[Vich\Uploadable]
class ChampionSpell
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'champion_spell_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\Column(length: 10)]
    private ?string $slot = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tooltip = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxrank = null;

    #[ORM\Column(nullable: true)]
    private ?array $cooldown = null;

    #[ORM\Column(nullable: true)]
    private ?array $cost = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cooldownBurn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $costBurn = null;

    #[ORM\Column(nullable: true)]
    private ?array $spellRange = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rangeBurn = null;

    #[ORM\ManyToOne(inversedBy: 'spells')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Champions $champion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getSlot(): ?string
    {
        return $this->slot;
    }

    public function setSlot(string $slot): static
    {
        $this->slot = $slot;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTooltip(): ?string
    {
        return $this->tooltip;
    }

    public function setTooltip(?string $tooltip): static
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getMaxrank(): ?int
    {
        return $this->maxrank;
    }

    public function setMaxrank(?int $maxrank): static
    {
        $this->maxrank = $maxrank;

        return $this;
    }

    public function getCooldown(): ?array
    {
        return $this->cooldown;
    }

    public function setCooldown(?array $cooldown): static
    {
        $this->cooldown = $cooldown;

        return $this;
    }

    public function getCost(): ?array
    {
        return $this->cost;
    }

    public function setCost(?array $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCooldownBurn(): ?string
    {
        return $this->cooldownBurn;
    }

    public function setCooldownBurn(?string $cooldownBurn): static
    {
        $this->cooldownBurn = $cooldownBurn;

        return $this;
    }

    public function getCostBurn(): ?string
    {
        return $this->costBurn;
    }

    public function setCostBurn(?string $costBurn): static
    {
        $this->costBurn = $costBurn;

        return $this;
    }

    public function getSpellRange(): ?array
    {
        return $this->spellRange;
    }

    public function setSpellRange(?array $spellRange): static
    {
        $this->spellRange = $spellRange;

        return $this;
    }

    public function getRangeBurn(): ?string
    {
        return $this->rangeBurn;
    }

    public function setRangeBurn(?string $rangeBurn): static
    {
        $this->rangeBurn = $rangeBurn;

        return $this;
    }

    public function getChampion(): ?Champions
    {
        return $this->champion;
    }

    public function setChampion(?Champions $champion): static
    {
        $this->champion = $champion;

        return $this;
    }
}
