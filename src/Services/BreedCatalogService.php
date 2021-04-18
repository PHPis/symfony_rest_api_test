<?php

namespace App\Services;

use App\Entity\BreedCatalog;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BreedCatalogService extends AbstractController
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function createBreed(Request $request)
    {
        $breed = new BreedCatalog();
        $breed->setName($request->get('name'));
        $breed->setDescription($request->get('description'));
        $breed->setType($request->get('type'));
        try {
            $this->entityManager->persist($breed);
            $this->entityManager->flush();
            return $breed;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateBreed(Request $request, BreedCatalog $breed): ?BreedCatalog
    {
        $breed->setDescription($request->get('description'));
        try {
            $this->entityManager->persist($breed);
            $this->entityManager->flush();
            return $breed;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getAllBreeds(): ?array
    {
        return $this->entityManager->getRepository(BreedCatalog::class)
            ->findAll();
    }

    public function getBreed(int $id): ?BreedCatalog
    {
        return $this->entityManager->getRepository(BreedCatalog::class)
            ->find($id);
    }

    public function getBreedsByType(int $type): ?array
    {
        return $this->entityManager->getRepository(BreedCatalog::class)
            ->findBreedsByType($type);
    }

    public function deleteBreed(BreedCatalog $breed): ?int
    {
        try {
            $this->entityManager->remove($breed);
            $this->entityManager->flush();
            return 1;
        } catch (\Exception $e) {
            return null;
        }
    }

}