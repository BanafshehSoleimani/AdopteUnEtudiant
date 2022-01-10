<?php

namespace App\Repository;

use App\Classe\Filter;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Student) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


 public function findWithFilter(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd');
            // <=> Select * from product, category where product.category = category.id

        if(!empty($filter->domains))
        {
            $query=$query
                ->andWhere('d.id IN (:domains)') // <=> and category.id in :value
                ->setParameter('domains', $filter->domains);
        }
        if(!empty($filter->string))
        {
            $query=$query
                ->andWhere('s.lastname LIKE :string OR d.name LIKE :string')
                ->setParameter('string', "%{$filter->string}%");
        }


        return $query->getQuery()->getResult();
    }



    public function findWithFilterInformatique(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Informatique");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }


    public function findWithFilterCommerce(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Commerce");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }


    public function findWithFilterInformation(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Information");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }

    public function findWithFilterSante(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Santé");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }
 

    public function findWithFilterIndustrie(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Industrie");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }

    public function findWithFilterBanqueEtAssurances(Filter $filter)
    {
        $query = $this 
            ->createQueryBuilder('s')
            ->select('d','s')
            ->join('s.domain', 'd')
            ->andWhere('d.name IN (:domains)')
            ->setParameter('domains',"Banque et Assurances");
            // <=> Select * from product, category where product.category = category.id
        return $query->getQuery()->getResult();
    }


    

    // /**
    //  * @return Student[] Returns an array of Student objects
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
    public function findOneBySomeField($value): ?Student
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