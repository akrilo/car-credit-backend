<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\CreditRequest;
use App\Domain\Repository\CreditRequestRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditRequest>
 */
class CreditRequestRepository extends ServiceEntityRepository implements CreditRequestRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditRequest::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(int $id): ?CreditRequest
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(CreditRequest $creditRequest): void
    {
        $this->em->persist($creditRequest);
        $this->em->flush();
    }

    public function remove(CreditRequest $creditRequest): void
    {
        $this->em->remove($creditRequest);
        $this->em->flush();
    }

    //    /**
    //     * @return CreditRequest[] Returns an array of CreditRequest objects
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

    //    public function findOneBySomeField($value): ?CreditRequest
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
