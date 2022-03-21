<?php

namespace App\Repository;

use App\Entity\Scooter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scooter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scooter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scooter[]    findAll()
 * @method Scooter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScooterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scooter::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Scooter $entity, bool $flush = true): void
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
    public function remove(Scooter $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findFilteredBy($ids, $limit, $offset)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        if ($ids) {
            $idsArray = explode(',', $ids);

            $qb->orWhere(
                $qb->expr()->in('s.id', $idsArray)
            );
        }

//        dd($qb->getQuery()->getSQL());
        return $qb->getQuery()->getResult();
    }

    public function findUsingDQL($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT s
            FROM APP\Entity\Scooter s
            WHERE s.id = :id
        ');

        $query->setParameter('id', $id);

        return $query->getResult();
    }

    public function veryCostlySQLQuery($id)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM scooter s WHERE s.id = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
    // /**
    //  * @return Scooter[] Returns an array of Scooter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Scooter
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
