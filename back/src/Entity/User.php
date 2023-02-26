<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\GenderEnum;
use App\Entity\Trait\Timestamp\Timestampable;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['patient' => Patient::class, 'professional' => Professional::class])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['ap_create', 'user_list', 'user_detail'])]
    protected null|string|Uuid $id;

    #[ORM\Column(type: 'string', length: 180, unique: true, nullable: true)]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Assert\Email(groups: ['user_create'])]
    #[Groups(['user_create', 'user_list', 'user_detail'])]
    private string $email;

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: true)]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Groups(['user_create', 'user_detail'])]
    private string $phone;

    #[ORM\Column(type: 'string', length: 150)]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Groups(['user_create', 'user_list', 'user_detail', 'ap_detail'])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 150)]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Groups(['user_create', 'user_list', 'user_detail', 'ap_detail'])]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Assert\Choice(callback: [GenderEnum::class, 'values'], groups: ['user_create'])]
    #[Groups(['user_create', 'user_detail'])]
    private string $gender;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Groups(['user_create', 'user_detail'])]
    private \DateTimeInterface $birthday;

    /**
     * @var string[]
     */
    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Groups(['user_create'])]
    private string $password;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return (string) $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): \DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
