<?php

namespace App\Entity;

use App\Repository\LogUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogUserRepository::class)]
#[ORM\Table(name: 'log_user')]
#[ORM\Index(columns: ['login_at'], name: 'idx_log_user_login_at')]
class LogUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logUsers')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $loginAt;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isSuccess = true;

    #[ORM\Column(type: Types::STRING, length: 45, nullable: true)]
    private ?string $ipAddress = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $userAgent = null;

    public function __construct()
    {
        $this->loginAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLoginAt(): \DateTimeImmutable
    {
        return $this->loginAt;
    }

    public function setLoginAt(\DateTimeImmutable $loginAt): self
    {
        $this->loginAt = $loginAt;

        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function setIsSuccess(bool $isSuccess): self
    {
        $this->isSuccess = $isSuccess;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }
}
