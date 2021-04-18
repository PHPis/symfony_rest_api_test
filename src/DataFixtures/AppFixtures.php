<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\BreedCatalog;
use App\Entity\Breeder;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em) {
        $this->entityManager = $em;
    }

    public function load(ObjectManager $manager) {
        $breedCats = ['Домашняя', 'Сиамская', 'Мейнкун', 'Вислоухий', 'Британская'];
        $breedDogs = ['Домашняя', 'Бигль', 'Овчарка', 'Мопс', 'Шпиц'];
        $i = 1;
        foreach ($breedCats as $breed) {
            $breedName = new BreedCatalog();
            $breedName->setName($breed);
            $breedName->setType(Animal::TYPES['cat']);
            $this->addReference('cat-breed'.$i, $breedName);
            $manager->persist($breedName);
            $i++;
        }
        $i = 1;
        foreach ($breedDogs as $breed) {
            $breedName = new BreedCatalog();
            $breedName->setName($breed);
            $breedName->setType(Animal::TYPES['dog']);
            $this->addReference('dog-breed'.$i, $breedName);
            $manager->persist($breedName);
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
            $animal = new Animal();
            $animal->setName('Sweetie'.$animalCount);
            $animal->setBirthday(new \DateTime());
            $animal->setType($type);
            $animal->setBreed($breed);
            $animal->setBreeder($breeder);
            $manager->persist($animal);
            $animalCount--;
        }

        $manager->flush();
    }
}