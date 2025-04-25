<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\DTO\CarDetailDTO;
use App\Application\DTO\CarListDTO;
use App\Domain\Repository\CarRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/cars')]
class CarController extends AbstractController
{
    public function __construct(
        private CarRepositoryInterface $carRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('', name: 'cars_list', methods: ['GET'])]
    public function list(): Response
    {
        $cars = $this->carRepository->findAll();

        $carDTOs = array_map(fn($car) => new CarListDTO($car), $cars);

        $jsonData = $this->serializer->serialize($carDTOs, 'json');

        return new Response($jsonData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/{id}', name: 'car_detail', methods: ['GET'])]
    public function detail(int $id): Response
    {
        $car = $this->carRepository->findById($id);
        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        $carDTO = new CarDetailDTO($car);

        $jsonData = $this->serializer->serialize($carDTO, 'json');

        return new Response($jsonData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
