<?php

namespace App\Repository;

use App\Entity\Zasoby;
use App\Entity\Artykul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Zasoby>
 *
 * @method Zasoby|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zasoby|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zasoby[]    findAll()
 * @method Zasoby[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZasobyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zasoby::class);
    }

    public function save(Zasoby $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Zasoby $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Zasoby[] Returns an array of Zasoby objects
//     */
   public function findByExampleField($value)
   {
       return $this->createQueryBuilder('z')
       -> join('z.Nazwa_Artykulu','na')
            ->Where('na.id = :val')
     ->setParameter('val', $value)
    //   ->andWhere('z.magazyn = :val')
    //        ->setParameter('val', $value)
        //    -> join('z.magazyn','ma')
        //     ->Where('ma.id = :param')//magazyn id
        //         ->setParameter('param',$value )
         //  ->setParameter('val2',$v)
            
            // ->join('z.Jednostka_Miary','jm')
        //    ->orderBy('z.id', 'ASC')
        //    ->setMaxResults(10)
           ->getQuery()
          ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Zasoby
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
