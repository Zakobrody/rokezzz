<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\ApplyRead;
use App\Controller\ApplyNotRead;
use App\Repository\ApplyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApplyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get( ),
        new Post(),
        new GetCollection(
            uriTemplate: '/applies-read',
            controller: ApplyRead::class,
            normalizationContext: [
                'groups' => ['apply:read'],
            ],
        ),
        new GetCollection(
            uriTemplate: '/applies-not-read',
            controller: ApplyNotRead::class,
            normalizationContext: [
                'groups' => ['apply:read'],
            ],
        )
    ],
    normalizationContext: [
        'groups' => ['apply:read'],
    ],
    denormalizationContext: [
        'groups' => ['apply:write'],
    ],
    paginationItemsPerPage: 10
)]
#[ApiFilter(
    OrderFilter::class,
    properties: ['firstname', 'lastname','email','phone','expectedSalary', 'createdAt']
)]
class Apply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['apply:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['apply:read', 'apply:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50, maxMessage: 'Describe your loot in 50 chars or less')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['apply:read', 'apply:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50, maxMessage: 'Describe your loot in 50 chars or less')]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['apply:read', 'apply:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 16)]
    #[Groups(['apply:read', 'apply:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: "/^[0-9\+]\d*$/")]
    #[Assert\Length(min: 9, max: 16, maxMessage: 'Describe your loot in 16 chars or less')]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['apply:read', 'apply:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100, maxMessage: 'Describe your loot in 100 chars or less')]
    private ?string $position = null;

    #[ORM\Column(length: 32)]
    #[Groups(['apply:read'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $level = null;

    #[ORM\Column]
    #[Groups(['apply:read', 'apply:write'])]
    #[Assert\NotBlank]
    #[Assert\LessThan(value: 25000, message: 'Max value is 25000')]
    #[Assert\GreaterThan(value: 2000, message: 'Min value is 2000')]
    #[Assert\Type(type: "numeric")]
    #[Assert\Positive]
    private ?float $expectedSalary = null;

    #[ORM\Column]
    #[Groups(['apply:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups(['apply:read'])]
    private ?bool $isRead = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isRead = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function setLevelByExpectedSalary(string $expectedSalary): void
    {
        if ($expectedSalary < 5000) {
            $this->level = 'junior';
        } elseif ($expectedSalary < 10000) {
            $this->level = 'regular';
        } else {
            $this->level = 'senior';
        }
    }

    public function getExpectedSalary(): ?float
    {
        return $this->expectedSalary;
    }

    public function setExpectedSalary(float $expectedSalary): static
    {
        $this->expectedSalary = $expectedSalary;
        $this->setLevelByExpectedSalary($expectedSalary);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): static
    {
        $this->isRead = $isRead;

        return $this;
    }
}
