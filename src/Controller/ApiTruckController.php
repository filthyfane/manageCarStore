<?php

namespace App\Controller;

use App\Entity\Truck;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/truck", methods={"GET", "POST", "OPTIONS"})
 */
class ApiTruckController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $em;
    /** @var ApiService */
    private $apiService;

    /**
     * @param EntityManagerInterface $em
     * @param ApiService $apiService
     */
    public function __construct(EntityManagerInterface $em, ApiService $apiService)
    {
        $this->em = $em;
        $this->apiService = $apiService;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function testMethod(): JsonResponse
    {
        return $this->json(['test' => 'test']);
    }

    /**
     * @Route("/add", methods={"POST", "OPTIONS"})
     */
    public function addTruck(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $truck = new Truck();
        $truck = $this->apiService->setProperties($data, $truck);

        return $this->validateAndSaveData($truck);
    }

    /**
     * @Route("/update/{truck}", methods={"POST", "OPTIONS"})
     */
    public function updateTruck(Request $request, ?Truck $truck): JsonResponse
    {
        if (is_null($truck)) {
            return $this->json([
                'success' => false,
                'errMsgs' => ['Invalid truck ID'],
            ], 400);
        }

        $data = json_decode($request->getContent(), true);
        $truck = $this->apiService->setProperties($data, $truck);

        return $this->validateAndSaveData($truck);
    }

    /**
     * @Route("/delete/{truck}", methods={"GET", "OPTIONS"})
     */
    public function deleteTruck(Request $request, ?Truck $truck): JsonResponse
    {
        if (is_null($truck)) {
            return $this->json([
                'success' => false,
                'errMsgs' => ['Invalid truck ID'],
            ], 400);
        }

        $this->em->remove($truck);
        $this->em->flush();

        return $this->json(['success' => true]);
    }

    protected function validateAndSaveData($truck): JsonResponse
    {
        $validated = $this->apiService->validateEntity($truck);
        if (!is_null($validated)) {
            return $validated;
        }

        try {
            $this->em->persist($truck);
            $this->em->flush();
            return $this->json(['success' => true], 400);
        } catch (Exception $e) {
            return $this->json([
                'success' => false,
                'errorMsgs' => ['Error when saving to database']
            ], 400);
        }
    }
}