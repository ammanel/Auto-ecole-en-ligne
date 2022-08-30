<?php

namespace App\Repository;

use App\Entity\AutoEcole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutoEcole>
 *
 * @method AutoEcole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutoEcole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutoEcole[]    findAll()
 * @method AutoEcole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutoEcoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutoEcole::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AutoEcole $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(AutoEcole $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function UpdateNotifications($personne)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'UPDATE App\Entity\Message p SET p.lu = true
            WHERE p.lu = false and  p.RecuPar = :personne
            '
        )->setParameter('personne',$personne);

        // returns an array of Product objects
        return $query->getResult();
    }

    public function listeNotifications($personne)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Message p
            WHERE p.lu = false and p.RecuPar = :personne ORDER BY p.DateEnvoi DESC'
            
        )->setParameter('personne',$personne);

        // returns an array of Product objects
        return $query->getResult();
    }


/*
    public function getApprenant($value)
    {

        $entitymanager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p.Telephone, p.nom
            FROM App\Entity\Personne p
            INNER JOIN App\Entity\Choisir c
            ON p.id = c.idApprenant
            '
        )->setParameter('price', $price);

        // returns an array of Product objects
        return $query->getResult();

       /* return $this->createQueryBuilder('od')
        ->join('od.order', 'o')
        ->addSelect('o')
        ->where('o.userid = :userid')
        ->andWhere('od.orderstatusid IN (:orderstatusid)')
        ->setParameter('userid', $userid)
        ->setParameter('orderstatusid', array(5, 6, 7, 8, 10))
        ->getQuery()->getResult()*/
   

    // /**
    //  * @return AutoEcole[] Returns an array of AutoEcole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AutoEcole
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
