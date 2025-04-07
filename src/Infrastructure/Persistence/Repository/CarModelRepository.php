<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\CarModel;
use App\Domain\Repository\CarModelRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarModel>
 */
class CarModelRepository extends ServiceEntityRepository implements CarModelRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarModel::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(int $id): ?CarModel
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(CarModel $carModel): void
    {
        $this->em->persist($carModel);
        $this->em->flush();
    }

    public function remove(CarModel $carModel): void
    {
        $this->em->remove($carModel);
        $this->em->flush();
    }

    //    /**
    //     * @return CarModel[] Returns an array of CarModel objects
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

    //    public function findOneBySomeField($value): ?CarModel
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
