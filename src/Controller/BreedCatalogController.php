<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\BreedCatalog;
use App\Helpers\ResponseHelper;
use App\Services\BreedCatalogService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BreedCatalogController
 * @package App\Controller
 * @Route ("/api", name="breedCatalog.")
 */
class BreedCatalogController extends AbstractController
{
    private $responseHelper, $breedCatalogService;

    public function __construct(ResponseHelper $responseHelper, BreedCatalogService $breedCatalogService)
    {
        $this->responseHelper = $responseHelper;
        $this->breedCatalogService = $breedCatalogService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/breeds", name="breed_add", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        try{
            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('name') || !$request->get('type')){
                throw new \Exception();
            }
            $result = $this->breedCatalogService->createBreed($request);
            return $result ? $this->responseHelper->successResponse("Breed added successfully") : $this->responseHelper->errorResponse("Breed wasn't added. Error on save.");
        } catch (\Exception $e) {
            return $this->responseHelper->errorResponse("Data no valid");
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return BreedCatalog|null
     * @Route("/breeds/{id}", name="breed_put", methods={"PUT"})
     */
    public function updateBreed(Request $request, int $id): ?JsonResponse
    {
        try{
            $breed = $this->breedCatalogService->getBreed($id);
            if (!$breed)
                return $this->responseHelper->errorResponse("Breed wasn't found.");

            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('description') ){
                throw new \Exception();
            }
            $result = $this->breedCatalogService->updateBreed($request, $breed);
            return $result ? $this->responseHelper->successResponse("Breed updated successfully") : $this->responseHelper->errorResponse("Breed wasn't updated. Error on save.");
        } catch (\Exception $e) {
            return $this->responseHelper->errorResponse("Data no valid");
        }
    }

    /**
     * @param int $id
     * @return BreedCatalog|null
     * @Route("/breeds/{id}", name="breed_delete", methods={"DELETE"})
     */
    public function deleteBreed(int $id): ?JsonResponse
    {
        $breed = $this->breedCatalogService->getBreed($id);
        if (!$breed)
            return $this->responseHelper->errorResponse("Breed wasn't found.");

        $result = $this->breedCatalogService->deleteBreed($breed);
        return $result ? $this->responseHelper->successResponse('Deleted successfully.') : $this->responseHelper->errorResponse("Breed wasn't deleted. Error on delete.");
    }

    /**
     * @param int $id
     * @return BreedCatalog|null
     * @Route("/breeds/{id}", name="breed_get", methods={"GET"})
     */
    public function showBreed(int $id): ?JsonResponse
    {
        $breed = $this->breedCatalogService->getBreed($id);
        return $breed ? $this->responseHelper->response($breed) : $this->responseHelper->errorResponse("Breed wasn't found.", 404);
    }

    /**
     * @return JsonResponse|null
     * @Route("/breeds", name="breeds", methods={"GET"})
     */
    public function showAllBreed(): ?JsonResponse
    {
        $result = $this->breedCatalogService->getAllBreeds();
        return $result ? $this->responseHelper->response($result) : $this->responseHelper->errorResponse("Breeds weren't found.");
    }

    /**
     * @param string $type
     * @return JsonResponse|null
     * @Route("/breeds/type/{type}", name="breeds_type", methods={"GET"})
     */
    public function showBreedByType(string $type): ?JsonResponse
    {
        if (!($animalType = Animal::TYPES["$type"] ?: null))
            return $this->responseHelper->errorResponse("This type of animal was not found.");

        $result = $this->breedCatalogService->getBreedsByType($animalType);
        return $result ? $this->responseHelper->response($result) : $this->responseHelper->errorResponse("Breeds weren't found.");
    }

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
