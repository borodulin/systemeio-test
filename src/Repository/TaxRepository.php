<?php

namespace App\Repository;

use App\Entity\Tax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tax|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tax|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tax[] findAll()
 * @method Tax[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tax::class);
    }

    public function findActualByCountryCode(string $countryCode): ?Tax
    {
        return $this->createQueryBuilder('tax')
            ->andWhere('tax.terminatedAt IS NULL')
            ->andWhere('tax.countryCode = :countryCode')
            ->setParameter('countryCode', $countryCode)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
