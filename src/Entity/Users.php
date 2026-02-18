<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Attribute as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Un compte est déjà associé à cette adresse e-mail.')]
#[UniqueEntity(fields: ['username'], message: "Ce nom d'utilisateur est déjà pris.")]
#[Vich\Uploadable]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[Vich\UploadableField(mapping: 'profile_pictures', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    // NOTE: This field and the next one need to be nullable, otherwise the deletion won't work
    //       if you want non-nullable fields, set the "erase_fields" option to false in the mapping config
    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ranks = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $positions = null;

    /**
     * @var Collection<int, Topics>
     */
    #[ORM\OneToMany(targetEntity: Topics::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $topics;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserSettings $userSettings = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about_me = null;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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

    public function getRanks(): ?string
    {
        return $this->ranks;
    }

    public function setRanks(?string $ranks): static
    {
        $this->ranks = $ranks;

        return $this;
    }

    public function getPositions(): ?string
    {
        return $this->positions;
    }

    public function setPositions(?string $positions): static
    {
        $this->positions = $positions;

        return $this;
    }

    /**
     * @return Collection<int, Topics>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topics $topic): static
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->setAuthor($this);
        }

        return $this;
    }

    public function removeTopic(Topics $topic): static
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getAuthor() === $this) {
                $topic->setAuthor(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUserSettings(): ?UserSettings
    {
        return $this->userSettings;
    }

    public function setUserSettings(UserSettings $userSettings): static
    {
        // set the owning side of the relation if necessary
        if ($userSettings->getUser() !== $this) {
            $userSettings->setUser($this);
        }

        $this->userSettings = $userSettings;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->about_me;
    }

    public function setAboutMe(?string $about_me): static
    {
        $this->about_me = $about_me;

        return $this;
    }
}
