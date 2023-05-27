<?php

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    public const EDUCATION_TYPE_SCHOOL = "school";
    public const EDUCATION_TYPE_SPECIAL = "special";
    public const EDUCATION_TYPE_HIGHER = "higher";

    public const EDUCATION_TYPES = [
        self::EDUCATION_TYPE_SCHOOL => 'Среднее образование',
        self::EDUCATION_TYPE_SPECIAL => 'Специальное образование',
        self::EDUCATION_TYPE_HIGHER => 'Высшее образование',
    ];

    public const MEGAFON = "megafon";
    public const BEELINE = "beeline";
    public const MTC = "mts";

    public const PHONE_OPERATORS = [
        self::MEGAFON => 'Мегафон',
        self::BEELINE => 'Билайн',
        self::MTC => 'МТС'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(name: 'phone', type: 'string')]
    #[Assert\NotBlank]
    private ?string $phone = null;

    #[ORM\Column(name: 'email', type: 'string')]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(name: 'education', type: 'string')]
    #[Assert\NotBlank]
    private ?string $education = null;

    #[ORM\Column(name: 'agreed_to_personal_data_collect', type: 'boolean')]
    private bool $agreedToPersonalDataCollect;

    #[ORM\Column(name: 'score', type: 'integer')]
    private int $score;

    #[ORM\Column(name: 'operator', type: 'string', nullable: true)]
    private ?string $operator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function getEducationString(): ?string
    {
        return self::EDUCATION_TYPES[$this->education];
    }

    public function setEducation(?string $education): void
    {
        $this->education = $education;
    }

    public function isAgreedToPersonalDataCollect(): bool
    {
        return $this->agreedToPersonalDataCollect;
    }

    public function setAgreedToPersonalDataCollect(bool $agreedToPersonalDataCollect): void
    {
        $this->agreedToPersonalDataCollect = $agreedToPersonalDataCollect;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(?string $operator): void
    {
        $this->operator = $operator;
    }
}
