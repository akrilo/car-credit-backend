<?php

namespace App\UI\Controller;

use App\Application\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/request')]
class RequestController extends AbstractController
{
    public function __construct(private RequestService $requestService) {}

    #[Route('', name: 'request_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['carId'], $data['programId'], $data['initialPayment'], $data['loanTerm'])) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $success = $this->requestService->saveRequest(
            (int)$data['carId'],
            (int)$data['programId'],
            (float)$data['initialPayment'],
            (int)$data['loanTerm']
        );

        return $this->json(['success' => $success]);
    }
}
