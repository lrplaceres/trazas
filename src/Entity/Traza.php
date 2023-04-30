<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TrazaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrazaRepository::class)]
#[ApiResource]
class Traza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column]
    private ?int $timeproxy = null;

    #[ORM\Column(length: 255)]
    private ?string $ip = null;

    #[ORM\Column(length: 255)]
    private ?string $resultCacheCode = null;

    #[ORM\Column]
    private ?float $lenghtContent = null;

    #[ORM\Column(length: 255)]
    private ?string $method = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $proxyHierarcheRoute = null;

    #[ORM\Column(length: 255)]
    private ?string $contentType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeproxy(): ?int
    {
        return $this->timeproxy;
    }

    public function setTimeproxy(int $timeproxy): self
    {
        $this->timeproxy = $timeproxy;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getResultCacheCode(): ?string
    {
        return $this->resultCacheCode;
    }

    public function setResultCacheCode(string $resultCacheCode): self
    {
        $this->resultCacheCode = $resultCacheCode;

        return $this;
    }

    public function getLenghtContent(): ?float
    {
        return $this->lenghtContent;
    }

    public function setLenghtContent(float $lenghtContent): self
    {
        $this->lenghtContent = $lenghtContent;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getProxyHierarcheRoute(): ?string
    {
        return $this->proxyHierarcheRoute;
    }

    public function setProxyHierarcheRoute(string $proxyHierarcheRoute): self
    {
        $this->proxyHierarcheRoute = $proxyHierarcheRoute;

        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
