<?php

namespace App\Repository;

use App\Entity\Filter;
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
        if ($user->getAdministrator()) {
            return $this->createQueryBuilder('t')
                ->join('t.organiser', 'u')
                ->join('u.site', 's')
                ->orderBy('t.id', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('t')
                ->join('t.organiser', 'u')
                ->join('u.site', 's')
                ->andWhere('s = :val')
                ->setParameter('val', $user->getSite())
                ->orderBy('t.id', 'ASC')
                ->getQuery()
                ->getResult();
        }

    }

    public function filterTrip(Filter $filter, User $user)
    {
        $qb = $this->createQueryBuilder('t')
            ->join('t.organiser', 'u')
            ->join('u.site', 's');


        if ($filter->getRegistered()===true){
            $qb->andWhere(':person MEMBER OF t.registereds')
                ->setParameter('person', $user);
        }

        if ($filter->getPastTrip()===true){
            $qb->andWhere('t.endDateTime < :auj')
                ->setParameter('auj', new \DateTime('now'));
        }

        if ($filter->getSite()!==null){
            $qb->andWhere('s = :val')
                ->setParameter('val', $filter->getSite());
        }

        if ($filter->getOrganiser()===true){
            $qb->andWhere('t.organiser = :org')
                ->setParameter('org', $user);
        }

        $qb->andWhere('t.startDateTime > :sdt')
            ->setParameter('sdt', $filter->getDebDate());

        $qb->andWhere('t.endDateTime < :edt')
            ->setParameter('edt', $filter->getEndDateTime())
            ->orderBy('t.id', 'ASC');




        if ( ! empty($filter->getSearch())){
            $qb->andWhere('t.name like :search')
                ->setParameter('search', '%'.$filter->getSearch().'%');
        }








        return $qb->getQuery()->getResult();

//        return $this->createQueryBuilder('t')
//            ->join('t.organiser', 'u')
//            ->join('u.site', 's')
//            ->orderBy('t.id', 'ASC')
//            ->getQuery()
//            ->getResult();

    }

    public function getNumberOfTrips()
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t)');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }


}
