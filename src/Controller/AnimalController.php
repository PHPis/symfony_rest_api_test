<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Helpers\ResponseHelper;
use App\Services\AnimalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnimalController
 * @package App\Controller
 * @Route ("/api/animals", name="animals.")
 */
class AnimalController extends AbstractController
{

    private $responseHelper, $animalService;

    public function __construct(ResponseHelper $responseHelper, AnimalService $animalService)
    {
        $this->responseHelper = $responseHelper;
        $this->animalService = $animalService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/", name="animal_add", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        try{
            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('name') || !$request->get('type') ||
                !$request->get('birthday') || !$request->get('breed') || !$request->get('breeder')) {
                throw new \Exception();
            }
            $result = $this->animalService->createAnimal($request);
            return $result ? $this->responseHelper->successResponse("Animal added successfully") : $this->responseHelper->errorResponse("Animal wasn't added. Error on save.");
        } catch (\Exception $e) {
            return $this->responseHelper->errorResponse("Data no valid");
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Animal|null
     * @Route("/{id}", name="animal_put", methods={"PUT"})
     */
    public function update(Request $request, int $id): ?JsonResponse
    {
        try{
            $animal = $this->animalService->getAnimal($id);
            if (!$animal)
                return $this->responseHelper->errorResponse("Animal wasn't found.");

            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('name') ){
                throw new \Exception();
            }
            $result = $this->animalService->updateAnimal($request, $animal);
            return $result ? $this->responseHelper->successResponse("Animal updated successfully") : $this->responseHelper->errorResponse("Animal wasn't updated. Error on save.");
        } catch (\Exception $e) {
            return $this->responseHelper->errorResponse("Data no valid");
        }
    }

    /**
     * @param int $id
     * @return Animal|null
     * @Route("/{id}", name="animal_delete", methods={"DELETE"})
     */
    public function delete(int $id): ?JsonResponse
    {
        $breed = $this->animalService->getAnimal($id);
        if (!$breed)
            return $this->responseHelper->errorResponse("Breed wasn't found.");

        $result = $this->animalService->deleteAnimal($breed);
        return $result ? $this->responseHelper->successResponse('Deleted successfully.') : $this->responseHelper->errorResponse("Breed wasn't deleted. Error on delete.");
    }

    /**
     * @param int $id
     * @return Animal|null
     * @Route("/{id}", name="animal_get", methods={"GET"})
     */
    public function showAnimal(int $id): ?JsonResponse
    {
        $breed = $this->animalService->getAnimal($id);
        return $breed ? $this->responseHelper->response($breed) : $this->responseHelper->errorResponse("Breed wasn't found.", 404);
    }

    /**
     * @return JsonResponse|null
     * @Route("/", name="animals", methods={"GET"})
     */
    public function getAllAnimals(): JsonResponse
    {
        $result = $this->animalService->getAllAnimals();
        return $result ? $this->responseHelper->response($result) : $this->responseHelper->errorResponse("Animals weren't found.");
    }

    //Todo: Вынести
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
