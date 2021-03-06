<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal implements \JsonSerializable
{
    const TYPES = [
        'dog' => 1,
        'cat' => 2,
    ];

    const MALE = 0;
    const FEMALE = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\ManyToOne(targetEntity=BreedCatalog::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breed;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Breeder::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $breeder;

    /**
     * @ORM\ManyToOne(targetEntity=Animal::class)
     */
    private $mother;

    /**
     * @ORM\ManyToOne(targetEntity=Animal::class)
     */
    private $father;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBreed(): ?BreedCatalog
    {
        return $this->breed;
    }

    public function setBreed(?BreedCatalog $breed): self
    {
        $this->breed = $breed;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBreeder(): ?Breeder
    {
        return $this->breeder;
    }

    public function setBreeder(?Breeder $breeder): self
    {
        $this->breeder = $breeder;

        return $this;
    }

    //Todo: ?????????????????????? ?? BreedCatalog
    public function getAnimalType()
    {
        $types = array_flip(Animal::TYPES);
        return $types[$this->type];
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "birthday" => $this->getBirthday(),
            "type" => $this->getAnimalType(),
            "mother" => $this->getMother(),
            "father" => $this->getFather(),
            "gender" => $this->getGenderType(),
        ];
    }

    public function getMother(): ?self
    {
        return $this->mother;
    }

    public function setMother(?self $mother): self
    {
        $this->mother = $mother;

        return $this;
    }

    public function getFather(): ?self
    {
        return $this->father;
    }

    public function setFather(?self $father): self
    {
        $this->father = $father;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function getGenderType(): ?string
    {
        return $this->gender ? 'FEMALE' : 'MALE';
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}
