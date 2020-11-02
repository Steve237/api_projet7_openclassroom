<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ApiResource
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listuser", "listclient", "detailuser"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listuser", "listclient", "detailuser"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listuser", "listclient", "detailuser"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listuser", "listclient", "detailuser"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"listuser"})
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
