<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Word::class);
    }

    public function randomWords() {

        $result = $this->createQueryBuilder('w')
            //->select('w.id')
            ->getQuery()
            ->getResult()
            ;

        shuffle($result);
        $result = array_slice($result, 0, 4);
        //dump($result); die;
        return $result;
//        $em = $this->getEntityManager();
//        $query = $em->createQuery('SELECT w FROM App\Entity\Word w ORDER BY RAND() LIMIT 4');
//        dump($query->execute()); die;
//        // возвращает массив объектов Товар
//        return $query->getResult();

//        $rsm = new ResultSetMapping();
//        $query = $this->getEntityManager()
//            ->createNativeQuery('SELECT * FROM `word` ORDER BY RAND() LIMIT 4', $rsm);
//        $words = $query->getResult();
//        var_dump($query->getSQL());
//        dump($words); die;

    }
//    /**
//     * @return Word[] Returns an array of Word objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Word
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
