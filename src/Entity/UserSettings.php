<?php

namespace App\Entity;

use App\Repository\UserSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSettingsRepository::class)]
class UserSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userSettings', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column]
    private ?bool $topic_answers = null;

    #[ORM\Column]
    private ?bool $topic_ask = null;

    #[ORM\Column]
    private ?bool $upvotes = null;

    #[ORM\Column]
    private ?bool $shares = null;

    #[ORM\Column]
    private ?bool $moderation = null;

    #[ORM\Column]
    private ?bool $messages = null;

    #[ORM\Column]
    private ?bool $comments = null;

    #[ORM\Column]
    private ?bool $replies = null;

    #[ORM\Column]
    private ?bool $mentions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function isTopicAnswers(): ?bool
    {
        return $this->topic_answers;
    }

    public function setTopicAnswers(bool $topic_answers): static
    {
        $this->topic_answers = $topic_answers;

        return $this;
    }

    public function isTopicAsk(): ?bool
    {
        return $this->topic_ask;
    }

    public function setTopicAsk(bool $topic_ask): static
    {
        $this->topic_ask = $topic_ask;

        return $this;
    }

    public function isUpvotes(): ?bool
    {
        return $this->upvotes;
    }

    public function setUpvotes(bool $upvotes): static
    {
        $this->upvotes = $upvotes;

        return $this;
    }

    public function isShares(): ?bool
    {
        return $this->shares;
    }

    public function setShares(bool $shares): static
    {
        $this->shares = $shares;

        return $this;
    }

    public function isModeration(): ?bool
    {
        return $this->moderation;
    }

    public function setModeration(bool $moderation): static
    {
        $this->moderation = $moderation;

        return $this;
    }

    public function isMessages(): ?bool
    {
        return $this->messages;
    }

    public function setMessages(bool $messages): static
    {
        $this->messages = $messages;

        return $this;
    }

    public function isComments(): ?bool
    {
        return $this->comments;
    }

    public function setComments(bool $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function isReplies(): ?bool
    {
        return $this->replies;
    }

    public function setReplies(bool $replies): static
    {
        $this->replies = $replies;

        return $this;
    }

    public function isMentions(): ?bool
    {
        return $this->mentions;
    }

    public function setMentions(bool $mentions): static
    {
        $this->mentions = $mentions;

        return $this;
    }
}
