<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @UniqueEntity(fields={"email"},
 * message="ce mail est déjà utilisé, veuillez en saisir un autre")
 * @ApiResource(collectionOperations={
 *         "get"={
 *          "method"="GET",
 *          "path"="/clients",
 *          },
 *          "post"={
 *              "method"="POST",
 *              "access_control"="is_granted('ROLE_ADMIN')",
 *              "access_control_message"="Vous n'avez pas le droit d'accès à cette ressource"
 *              }      
 *          },
 *         itemOperations={
 *          "get"={
 *          "method"="GET",
 *          "path"="client/{id}"
 *          },
 *         "put_item_role_admin"={
 *          "method"="PUT",
 *          "path"="/client/{id}",
 *          "access_control"="is_granted('ROLE_ADMIN')", 
 *           "access_control_message"="Vous n'avez pas accès à cette ressource"
 *          },
 *          "delete"={
 *          "method"="DELETE",
 *          "path"="/client/{id}",
 *          "access_control"="is_granted('ROLE_ADMIN')", 
 *          "access_control_message"="Vous n'avez pas accès à cette ressource"
 *          },
 *      }
 * )
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listclient", "detailuser"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listclient", "detailuser"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listclient"})
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listclient", "detailuser"})
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="client")
     * @ApiSubresource
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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


    public function getUsername()
    {
        return $this->email;
    }


    
    public function getSalt()
    {
        return null;
    }


    public function getRoles()
    {
        return [$this->roles];
    }

    public function setRoles(?string $roles): self
    {
        if($roles == NULL) {
            
            $this->roles = "ROLE_USER";
        
        } else {
            $this->roles = $roles;
        }
    
        return $this;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

        return $this;
    }
}
