<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
      * @return Article[] Returns an array of Article objects
     */
    
    public function search($title):array
    { 
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * title FROM article a
            WHERE a.title = :title
            ORDER BY a.title ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title]);
        return $stmt->fetchAll();
        
    }
    

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    


    /**
     * @return Product[]
     */
    public function findTitle($title): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Article p
            WHERE p.title > :title
            ORDER BY p.title ASC'
        )->setParameter('title', $title);

        // returns an array of content objects
        return $query->getResult();
    }
}

