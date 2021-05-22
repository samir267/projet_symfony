<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fournisseur[]    findAll()
 * @method Fournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    // /**
    //  * @return Fournisseur[] Returns an array of Fournisseur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fournisseur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getMostFourWithGames()
    {
        $queryGetMostFourId = $this->getEntityManager()->createQueryBuilder()
            ->select("IDENTITY(t.code_four_jouet)")
            ->from("App\Entity\Jouet", "t")
            ->groupBy("t.code_four_jouet")
            ->orderBy("COUNT(t.code_four_jouet)", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $this->getEntityManager()->createQueryBuilder()
            ->select("f")
            ->from("App\Entity\Fournisseur", "f")
            ->where("f.code_four = :query")
            ->setParameter("query", $queryGetMostFourId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Fournisseur[] Returns a fournisseur with most jouet
     */
    public function getFourWithNoGame()
    {
        $getAllFourWithGame = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("IDENTITY(t.code_four_jouet)")
            ->from("App\Entity\Jouet", "t")
            ->getQuery()
            ->getResult();
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select("f")
            ->from("App\Entity\Fournisseur", "f")
            ->where("f.code_four NOT IN (:query)")
            ->setParameter("query", $getAllFourWithGame)
            ->getQuery()
            ->getResult();
    }
}

