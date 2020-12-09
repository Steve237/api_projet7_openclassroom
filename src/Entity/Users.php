<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ApiResource(collectionOperations={
 *          "get_all_user"={
 *          "method"="GET",
 *          "path"="/users/client",
 *          },
 *          "post"={
 *              "method"="POST",
 *              "access_control"="is_granted('ROLE_USER')",
 *              "access_control_message"="Vous n'avez pas le droit d'accès à cette ressource"
 *              }      
 *          },
 *          itemOperations={
 *           "get_client_id"={
 *          "method"="GET" 
 *          },
 *         "put_user"={
 *          "method"="PUT",
 *          "path"="/user/{id}",
 *          "access_control"="(is_granted('ROLE_USER') and object.getClient() == user) or is_granted('ROLE_ADMIN')", 
 *          "access_control_message"="Vous n'avez pas accès à cette ressource"
 *          },
 *         "delete"={
 *          "method"="DELETE",
 *          "path"="/user/{id}",
 *          "access_control"="(is_granted('ROLE_USER') and object.getClient() == user) or is_granted('ROLE_ADMIN')", 
 *          "security_message"="Vous n'êtes pas accès à cette ressource"
 *          }
 *      }
 * )
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
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
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
