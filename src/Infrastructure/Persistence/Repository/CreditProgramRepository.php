<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\CreditProgram;
use App\Domain\Repository\CreditProgramRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditProgram>
 */
class CreditProgramRepository extends ServiceEntityRepository implements CreditProgramRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(int $id): ?CreditProgram
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(CreditProgram $creditProgram): void
    {
        $this->em->persist($creditProgram);
        $this->em->flush();
    }

    public function remove(CreditProgram $creditProgram): void
    {
        $this->em->remove($creditProgram);
        $this->em->flush();
    }

    public function findPreferredByName(string $name): ?CreditProgram
    {
        return $this->findOneBy(['title' => $name]);
    }

    public function findBestAlternative(?string $excludeName = null): ?CreditProgram
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.interestRate', 'ASC') // Ищем с минимальной ставкой
            ->setMaxResults(1);

        if ($excludeName !== null) {
            $qb->andWhere('p.title != :excludeName')
               ->setParameter('excludeName', $excludeName);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAnyExcept(?string $excludeName = null): ?CreditProgram
    {
        $qb = $this->createQueryBuilder('p')
             ->setMaxResults(1);

        if ($excludeName !== null) {
            $qb->andWhere('p.title != :excludeName')
               ->setParameter('excludeName', $excludeName);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    //    /**
    //     * @return CreditProgram[] Returns an array of CreditProgram objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CreditProgram
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
