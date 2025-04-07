<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Domain\Entity\Car;
use App\Domain\Repository\CarRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/cars')]
class CarController extends AbstractController
{
    public function __construct(private CarRepositoryInterface $carRepository) {}

    #[Route('', name: 'cars_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $cars = $this->carRepository->findAll();
        $data = array_map(function (Car $car) {
            return [
                'id'    => $car->getId(),
                'brand' => [
                    'id'   => $car->getBrand()->getId(),
                    'name' => $car->getBrand()->getName(),
                ],
                'photo' => $car->getPhoto(),
                'price' => $car->getPrice(),
            ];
        }, $cars);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'car_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        $car = $this->carRepository->findById($id);
        if (!$car) {
            return $this->json(['error' => 'Car not found'], 404);
        }
        $data = [
            'id'    => $car->getId(),
            'brand' => [
                'id'   => $car->getBrand()->getId(),
                'name' => $car->getBrand()->getName(),
            ],
            'model' => [
                'id'   => $car->getModel()->getId(),
                'name' => $car->getModel()->getName(),
            ],
            'photo' => $car->getPhoto(),
            'price' => $car->getPrice(),
        ];

        return $this->json($data);
    }
}
