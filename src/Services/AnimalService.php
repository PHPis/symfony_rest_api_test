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
        $breed = new Animal();
        $breed->setType($request->get('type'));
        $breed->setName($request->get('name'));
        $breed->setBreed($this->getBreed($request->get('breed')));
        $breed->setBreeder($this->getBreeder($request->get('breeder')));
        try {
            $breed->setBirthday(new \DateTime($request->get('birthday')));
            $this->entityManager->persist($breed);
            $this->entityManager->flush();
            return $breed;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateAnimal(Request $request, Animal $breed): ?Animal
    {
        $breed->setName($request->get('name'));
        try {
            $this->entityManager->persist($breed);
            $this->entityManager->flush();
            return $breed;
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

    public function updateBreed(Request $request, Animal $animal): ?Animal
    {
        $animal->setName($request->get('description'));
        try {
            $this->entityManager->persist($animal);
            $this->entityManager->flush();
            return $animal;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getAnimal(int $id): ?Animal
    {
        return $this->entityManager->getRepository(Animal::class)
            ->find($id);
    }

    public function getAllAnimals(): ?array
    {
        return $this->entityManager->getRepository(Animal::class)
            ->findAll();
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