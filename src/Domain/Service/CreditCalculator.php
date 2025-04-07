<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\CreditProgram;
use App\Domain\Repository\CreditProgramRepositoryInterface;

class CreditCalculator
{
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
        $preferredProgram = null;
        $findPreferred = false;

         if ($initialPayment > 200000 && $loanTerm < 60) {
             $findPreferred = true;
             $programs = $this->creditProgramRepository->findAll();
             foreach ($programs as $p) {
                 if ($p->getTitle() === 'Alfa Energy') {
                     $preferredProgram = $p;
                     break;
                 }
             }

             if ($preferredProgram) {
                 return $preferredProgram;
             }
         }

         $allPrograms = $this->creditProgramRepository->findAll();
         if (empty($allPrograms)) {
             return null;
         }

         $alternativeProgram = null;
         $minRate = PHP_FLOAT_MAX;

         foreach ($allPrograms as $program) {
             if ($findPreferred && $program->getTitle() === 'Alfa Energy') {
                 continue;
             }

             // Ищем программу с минимальной ставкой среди остальных
             if ($program->getInterestRate() < $minRate) {
                 $minRate = $program->getInterestRate();
                 $alternativeProgram = $program;
             }
         }

         if (!$alternativeProgram && $findPreferred) {
             foreach ($allPrograms as $program) {
                 if ($program->getTitle() !== 'Alfa Energy') {
                     return $program;
                 }
             }
         }
         
         return $alternativeProgram;
    }

    private function calculateMonthlyPayment(float $loanAmount, float $annualRate, int $loanTerm): int
    {
        if ($annualRate == 0) {
            // Если ставка 0%, платеж равен сумме кредита, деленной на срок
            $monthlyPayment = $loanAmount / $loanTerm;
        } else {
            $monthlyRate = $annualRate / 12 / 100; // Месячная ставка в долях
            // Формула платежа
            $powTerm = pow(1 + $monthlyRate, $loanTerm);
            if ($powTerm - 1 == 0) {
                 return (int) round($loanAmount / $loanTerm);
            }
            $monthlyPayment = $loanAmount * ($monthlyRate * $powTerm) / ($powTerm - 1);
        }

        return (int) round($monthlyPayment);
    }
}
