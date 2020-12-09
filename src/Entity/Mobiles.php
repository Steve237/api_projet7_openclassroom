<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MobilesRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * @ORM\Entity(repositoryClass=MobilesRepository::class)
 * @UniqueEntity("name",message="Un mobile porte déjà ce nom")
 * @ApiResource(collectionOperations={
 *         "get"={
 *          "method"="GET",
 *          "path"="/mobiles",
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
*          "path"="mobile/{id}"
 *          },
 *         "put_item_role_admin"={
*          "method"="PUT",
*          "path"="/mobile/{id}",
*          "access_control"="is_granted('ROLE_ADMIN')", 
*           "access_control_message"="Vous n'avez pas accès à cette ressource"
*          },
*          "delete"={
*          "method"="DELETE",
*          "path"="/mobile/{id}",
*          "access_control"="is_granted('ROLE_ADMIN')", 
*          "access_control_message"="Vous n'avez pas accès à cette ressource"
 *          },
 *          
 *      }
 * )
 * 
*/
class Mobiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5,max=15,minMessage="5 caractères minimum requis",maxMessage="15 caractères maximum requis")
     * 
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5,max=20,minMessage="5 caractères minimum requis",maxMessage="20 caractères maximum requis")
    */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * Assert\IsNotBlank("message="vous devez indiquer capacité de stockage du mobile")
     */
    private $memory;

    /**
     * @ORM\Column(type="date")
    */
    private $releasedate;

    /**
     * @ORM\Column(type="date")
     */
    private $creationdate;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    public function __construct()
    {   //permet d'ajouter automatiquement la date lors de la creation du mobile
        $this->creationdate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMemory(): ?int
    {
        return $this->memory;
    }

    public function setMemory(int $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getReleasedate(): ?\DateTimeInterface
    {
        return $this->releasedate;
    }

    public function setReleasedate(\DateTimeInterface $releasedate): self
    {
        $this->releasedate = $releasedate;

        return $this;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
