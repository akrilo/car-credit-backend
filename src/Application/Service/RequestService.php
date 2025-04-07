<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\CreditRequest;
use App\Domain\Repository\CarRepositoryInterface;
use App\Domain\Repository\CreditProgramRepositoryInterface;
use App\Domain\Repository\CreditRequestRepositoryInterface;

class RequestService
{
    public function __construct(
        private CarRepositoryInterface $carRepository,
        private CreditProgramRepositoryInterface $creditProgramRepository,
        private CreditRequestRepositoryInterface $creditRequestRepository
    ) {}

    public function saveRequest(int $carId, int $programId, float $initialPayment, int $loanTerm): bool
    {
        $car = $this->carRepository->findById($carId);
        $creditProgram = $this->creditProgramRepository->findById($programId);

        if (!$car || !$creditProgram) {
            return false;
        }

        $creditRequest = new CreditRequest();
        $creditRequest->setCar($car);
        $creditRequest->setCreditProgram($creditProgram);
        $creditRequest->setInitialPayment($initialPayment);
        $creditRequest->setLoanTerm($loanTerm);
        $creditRequest->setCreatedAt(new \DateTime());

        $this->creditRequestRepository->save($creditRequest);

        return true;
    }
}
