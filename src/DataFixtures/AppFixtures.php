<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\BreedCatalog;
use App\Entity\Breeder;
use App\Entity\User;
use App\Services\AnimalService;
use App\Services\BreedCatalogService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;
    private BreedCatalogService $breedCatalogService;
    private AnimalService $animalService;

    public function __construct(EntityManagerInterface $em, BreedCatalogService $breedCatalogService, AnimalService $animalService) {
        $this->entityManager = $em;
        $this->breedCatalogService = $breedCatalogService;
        $this->animalService = $animalService;
    }

    public function load(ObjectManager $manager) {
        $breedCats = ['Домашняя', 'Сиамская', 'Мейнкун', 'Вислоухий', 'Британская'];
        $breedDogs = ['Домашняя', 'Бигль', 'Овчарка', 'Мопс', 'Шпиц'];
        $i = 1;
        foreach ($breedCats as $breed) {
            $req = new Request(['name' => $breed, 'type' => Animal::TYPES['cat']]);
            $breed = $this->breedCatalogService->createBreed($req);
            $this->addReference('cat-breed'.$i, $breed);
            $i++;
        }
        $i = 1;
        foreach ($breedDogs as $breed) {
            $req = new Request(['name' => $breed, 'type' => Animal::TYPES['dog']]);
            $breed = $this->breedCatalogService->createBreed($req);
            $this->addReference('dog-breed'.$i, $breed);
            $i++;
        }

        $userNames = ['Таня', 'Даня', 'Аня', 'Саня', 'Ваня'];
        $userSecondNames = ['Котейко', 'Собачко', 'Пушко', 'Мурчало', 'Рычало', 'Пузико'];
        $userCount = 10;
        while ($userCount > 0) {
            $user = new User();
            $user->setName($userNames[array_rand($userNames, 1)]);
            $user->setSecondName($userSecondNames[array_rand($userSecondNames, 1)]);
            $user->setEmail('email'.rand(1, 200). $userCount.'@mail.ru');
            $manager->persist($user);
            $this->addReference('user-ref'.$userCount, $user);
            $userCount--;
        }
        $manager->flush();
        $breederCount = 5;
        while ($breederCount > 0) {
            /** @var User $user */
            $user = $this->getReference('user-ref'.$breederCount);
            $breeder = new Breeder();
            $breeder->setName('Breeder'.$breederCount);
            $breeder->setUser($user);
            $breeder->setAddress('address');
            $manager->persist($breeder);
            $this->addReference('breeder-ref'.$breederCount, $breeder);
            $breederCount--;
        }
        $manager->flush();

        $animalCount = 20;
        while ($animalCount > 0) {
            $type = Animal::TYPES[$animalCount <= 10 ? 'cat' : 'dog'];
            /** @var BreedCatalog $breed */
            $breed = $this->getReference($animalCount <= 10 ? 'cat-breed'.rand(1, 5) : 'dog-breed'.rand(1, 5));
            /** @var Breeder $breeder */
            $breeder = $this->getReference('breeder-ref'.rand(1, 5));
            $req = new Request([
                'name' => 'Sweetie'.$animalCount,
                'birthday' => date_create('now')->format('Y-m-d'),
                'type' => $type,
                'breed' => $breed->getId(),
                'breeder' => $breeder->getId(),
                'gender' => rand(0, 1),
                ]);
            $this->animalService->createAnimal($req);
            $animalCount--;
        }
    }
}