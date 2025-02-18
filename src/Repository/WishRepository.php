<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wish>
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    /** Méthode personnalisée (version queryBuilder) pour récupérer une liste de wishes triés
     * Triés par date de création - descendant
     * @return array
     */
    public function findAllOrderedByDate(): array
    {
        $queryBuilder = $this->createQueryBuilder('query');
        $queryBuilder->addOrderBy('query.dateCreatedAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $query->setMaxResults(20);

        return $query->getResult();
    }

}
