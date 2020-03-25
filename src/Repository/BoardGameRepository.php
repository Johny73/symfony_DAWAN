<?php

namespace App\Repository;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BoardGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardGame[]    findAll()
 * @method BoardGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardGame::class);
    }

    /**
    * @return BoardGame[] Returns an array of BoardGame objects
    */
    public function findWithCategories()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.classifiedIn', 'c')
            ->addSelect('c')
            ->orderBy('b.releasedAt', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
    /**
     * @return BoardGame[] Returns an array of BoardGame objects
     * Alternatif en DQL
     */
public function findWithCategoriesBis()
{
     return $this->getEntityManager()->createQuery(
         'SELECT b, c FROM '.BoardGame::class.' b LEFT JOIN b.classifiedIn c ORDER BY b.releasedAt DESC'
     )->setMaxResults(50)
         ->getResult();
}
}
