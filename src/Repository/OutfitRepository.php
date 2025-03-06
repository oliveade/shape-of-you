<?php

namespace App\Repository;

use App\Entity\Outfit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Outfit>
 */
class OutfitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Outfit::class);
    }

    //    /**
    //     * @return Outfit[] Returns an array of Outfit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Outfit
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Outfit[] Returns an array of Outfit objects
     */
    public function findBySearchQuery(string $query, int $limit): array
    {
        $searchTerms = $this->extractSearchTerms($query);

        if (0 === \count($searchTerms)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('o');

        foreach ($searchTerms as $key => $term) {
            $queryBuilder
                ->orWhere('o.name LIKE :t_'.$key)
                ->setParameter('t_'.$key, '%'.$term.'%');
        }

        /** @var Outfit[] $result */
        $result = $queryBuilder
            ->orderBy('o.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * Transforms the search string into an array of search terms.
     *
     * @return string[]
     */
    private function extractSearchTerms(string $searchQuery): array
    {
        $terms = array_unique(u($searchQuery)->replaceMatches('/[[:space:]]+/', ' ')->trim()->split(' '));

        // ignore the search terms that are too short
        return array_filter($terms, static function ($term) {
            return 2 <= $term->length();
        });
    }

    /**
     * @return Outfit[] Returns an array of Outfit objects
     */
    public function findAllPublicOutfits($value): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.public = true')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Outfit[] Returns an array of Outfit objects
     */
    public function findUserPublicOutfits($createdBy): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.createdBy = :createdBy')
            ->setParameter('createdBy', $createdBy)
            ->andWhere('o.public = true')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Outfit Returns an Outfit objects
     */
    public function findUserPublicOutfit($createdBy, $outfitId): ?Outfit
    {
        return $this->createQueryBuilder('o')
            ->where('o.createdBy = :createdBy')
            ->setParameter('createdBy', $createdBy)
            ->andWhere('o.outfit = :outfitId')
            ->setParameter('outfitId', $outfitId)
            ->andWhere('o.public = true')
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
