<?php

namespace App\Repository;

use App\Entity\Commandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commandes>
 *
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }


//    public function findAllCommandesWithJointures(): array
//    {
//        return $this->createQueryBuilder('c')
//            ->addSelect('l', 'f')
//            ->leftJoin('c.livres', 'l')
//            ->leftJoin('c.fournisseur', 'f')
//            ->orderBy('c.id', 'ASC')
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commandes
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findDistinctDate()
{
    return $this->createQueryBuilder('c')
        ->select('DISTINCT c.Date_achat')
        ->orderBy('c.Date_achat', 'ASC')
        ->getQuery()
        ->getResult();
}
}
