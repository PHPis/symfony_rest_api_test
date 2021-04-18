<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnimalController
 * @package App\Controller
 * @Route ("/api", name="animals.")
 */
class AnimalController extends AbstractController
{
//    private $em;
//
//    public function __construct(EntityManager $em)
//    {
//        $this->em = $em;
//    }

    #[Route('/animals', name: 'getAnimals')]
    public function getAllAnimals(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AnimalController.php',
        ]);
    }
}
