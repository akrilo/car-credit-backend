<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\CreditProgram;
use App\Domain\Repository\CreditProgramRepositoryInterface;

class CreditCalculator
{
    private const PREFERRED_PROGRAM_NAME = 'Alfa Energy';
    private const PREFERRED_INITIAL_PAYMENT_THRESHOLD = 200000;
    private const PREFERRED_LOAN_TERM_THRESHOLD = 60;

    public function __construct(private CreditProgramRepositoryInterface $creditProgramRepository) {}

    public function calculate(int $price, float $initialPayment, int $loanTerm): array
    {
        $loanAmount = $price - $initialPayment;

        if ($loanAmount <= 0) {
             return ['error' => 'Loan amount must be positive'];
        }

        $program = $this->findCreditProgram($initialPayment, $loanTerm);

        if (!$program) {
             return ['error' => 'Suitable credit program not found'];
        }

        $monthlyPayment = $this->calculateMonthlyPayment(
            $loanAmount,
            $program->getInterestRate(),
            $loanTerm
        );

        return [
            'programId'      => $program->getId(),
            'interestRate'   => round($program->getInterestRate(), 1),
            'monthlyPayment' => $monthlyPayment,
            'title'          => $program->getTitle(),
        ];
    }

    private function findCreditProgram(float $initialPayment, int $loanTerm): ?CreditProgram
    {
        // Условие для поиска предпочтительной программы
        $findPreferred = $initialPayment > self::PREFERRED_INITIAL_PAYMENT_THRESHOLD
                         && $loanTerm < self::PREFERRED_LOAN_TERM_THRESHOLD;

        if ($findPreferred) {
            $preferredProgram = $this->creditProgramRepository->findPreferredByName(self::PREFERRED_PROGRAM_NAME);
            if ($preferredProgram) {
                return $preferredProgram;
            }
            // Если предпочтительная не найдена, ищем лучшую альтернативу, исключая ее имя
            $alternativeProgram = $this->creditProgramRepository->findBestAlternative(self::PREFERRED_PROGRAM_NAME);
            if ($alternativeProgram) {
                return $alternativeProgram;
            }
            // Если и альтернативы нет, ищем любую другую, кроме предпочтительной
            return $this->creditProgramRepository->findAnyExcept(self::PREFERRED_PROGRAM_NAME);
        }

        return $this->creditProgramRepository->findBestAlternative();
    }

    private function calculateMonthlyPayment(float $loanAmount, float $annualRate, int $loanTerm): int
    {
        if ($annualRate == 0) {
            $monthlyPayment = $loanAmount / $loanTerm;
        } else {
            $monthlyRate = $annualRate / 12 / 100;
            $powTerm = pow(1 + $monthlyRate, $loanTerm);
            if ($powTerm - 1 == 0) {
                 return (int) round($loanAmount / $loanTerm);
            }
            $monthlyPayment = $loanAmount * ($monthlyRate * $powTerm) / ($powTerm - 1);
        }

        return (int) round($monthlyPayment);
    }
}
