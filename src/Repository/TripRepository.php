<?php

namespace App\Repository;

use App\Entity\Trip;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    // /**
    //  * @return Trip[] Returns an array of Trip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findTripBySite(User $user)
    {


        // on crée un objet QueryBuilder pour retourner les sorties concernant le site
        $qb = $this->createQueryBuilder('t');
        $qb->addSelect('u');
        $qb->addSelect('s');
        $qb->join('t.organiser', 'u');
        $qb->join('u.site', 's');
        if ($user->getAdministrator() !== true) {
        $qb->andWhere('t.site = :val' );
        setParameter('val', $user->getSite());
        }
        $qb->orderBy('t.name', 'asc');
        $query = $qb->getQuery();
        return $query;

    }

    public function getNumberOfTrips() {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t)');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }


}
