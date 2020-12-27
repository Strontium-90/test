<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param $name
     *
     * @return array<Book>
     */
    public function search(string $name)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->leftJoin('b.authors', 'a')->addSelect('a')
            ->where($qb->expr()->like('b.name', ':name'))
            ->setParameter('name', '%'.$name.'%')
            ->orderBy('b.name')
            ->setMaxResults(20)
        ;

        // Тут обычно делают пагинацию
        return $qb->getQuery()->getResult();
    }
}
