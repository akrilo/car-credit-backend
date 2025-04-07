<?php

namespace App\UI\Controller;

use App\Domain\Service\CreditCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/credit')]
class CreditController extends AbstractController
{
    public function __construct(private CreditCalculator $creditCalculator) {}

    #[Route('/calculate', name: 'credit_calculate', methods: ['GET'])]
    public function calculate(Request $request): JsonResponse
    {
        $price = (int) $request->query->get('price', 0);
        $initialPayment = (float) $request->query->get('initialPayment', 0);
        $loanTerm = (int) $request->query->get('loanTerm', 0);

        if ($price <= 0 || $initialPayment < 0 || $loanTerm <= 0) {
            return $this->json(['error' => 'Invalid parameters'], 400);
        }

        $result = $this->creditCalculator->calculate($price, $initialPayment, $loanTerm);

        return $this->json($result);
    }
}
