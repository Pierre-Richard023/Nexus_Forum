<?php

namespace App\Entity;

use App\Repository\VotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VotesRepository::class)]
class Votes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Posts $post = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Topics $topic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Posts
    {
        return $this->post;
    }

    public function setPost(?Posts $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getTopic(): ?Topics
    {
        return $this->topic;
    }

    public function setTopic(?Topics $topic): static
    {
        $this->topic = $topic;

        return $this;
    }
}
