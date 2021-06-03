<?php

namespace App\Services;

use App\Entity\Animal;
use App\Entity\BreedCatalog;
use App\Entity\Breeder;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AnimalService extends AbstractController
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function createAnimal(Request $request)
    {
        $animal = new Animal();
        $animal->setType($request->get('type'));
        $animal->setName($request->get('name'));
        $animal->setBreed($this->getBreed($request->get('breed')));
        $animal->setGender($request->get('gender'));
        $animal->setBreeder($this->getBreeder($request->get('breeder')));

        $mother = $this->getAnimal($request->get('mother'));
        if ($mother && $mother->getGender() == Animal::FEMALE)
            $animal->setMother($mother);

        $father = $this->getAnimal($request->get('father'));
        if ($father && $father->getGender() == Animal::MALE)
            $animal->setFather($father);

        try {
            $animal->setBirthday(new \DateTime($request->get('birthday')));
            $this->entityManager->persist($animal);
            $this->entityManager->flush();
            return $animal;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateAnimal(Request $request, Animal $animal): ?Animal
    {
        $animal->setName($request->get('name'));
        $mother = $this->getAnimal($request->get('mother'));
        if ($mother && $mother->getGender() == Animal::FEMALE)
            $animal->setMother($mother);
        $father = $this->getAnimal($request->get('father'));
        if ($father && $father->getGender() == Animal::MALE)
            $animal->setFather($father);
        try {
            $this->entityManager->persist($animal);
            $this->entityManager->flush();
            return $animal;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getBreed(int $id): ?BreedCatalog
    {
        return $this->entityManager->getRepository(BreedCatalog::class)
            ->find($id);
    }

    public function getBreeder(int $id): ?Breeder
    {
        return $this->entityManager->getRepository(Breeder::class)
            ->find($id);
    }

    public function getAnimal(?int $id): ?Animal
    {
        return $this->entityManager->getRepository(Animal::class)
            ->find($id);
    }

    public function getAllAnimals(): ?array
    {
        return $this->entityManager->getRepository(Animal::class)
            ->findAll();
    }

    public function getFamilyTree(int $animal): ?array
    {
        $animal = $this->getAnimal($animal);
        return $this->treeBuilder($animal);
    }

    public function treeBuilder(?Animal $animal)
    {
        if(!$animal)
            return null;
        if (!$animal->getMother() && !$animal->getFather())
            return ['id'=> $animal->getId()];
        return ['current'=> $animal->getId(), 'mom' => $this->getParents($animal->getMother()), 'dad' => $this->getParents($animal->getFather())];
    }

    public function deleteAnimal(Animal $animal): ?int
    {
        try {
            $this->entityManager->remove($animal);
            $this->entityManager->flush();
            return 1;
        } catch (\Exception $e) {
            return null;
        }
    }
}