<?php

namespace App\Repository;

use App\Entity\Greffe;
use App\Entity\DossierMedical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GreffeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Greffe::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.donneur', 'd')->addSelect('d')
            ->leftJoin('g.groupeHLA', 'hla')->addSelect('hla')
            ->leftJoin('g.serologie', 's')->addSelect('s')
            ->leftJoin('g.prelevement', 'p')->addSelect('p')
            ->leftJoin('g.conditionnementImmunologique', 'c')->addSelect('c')
            ->getQuery()
            ->getResult();
    }

    public function countGreffes(): int
    {
         return $this->createQueryBuilder('g')
              ->select('COUNT(g.id)')
              ->getQuery()
              ->getSingleScalarResult();
    }

    /**
     *  Liste des greffes d’un dossier (historique)
     */
    public function findByDossierOrdered(DossierMedical $dossier): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier)
            ->orderBy('g.dateGreffe', 'ASC') // ou rangGreffe selon besoin métier
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupérer une greffe avec toutes ses relations (DETAIL PAGE)
     */
    public function findOneWithDetails(int $id): ?Greffe
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.donneur', 'd')->addSelect('d')
            ->leftJoin('g.groupeHLA', 'hla')->addSelect('hla')
            ->leftJoin('g.serologie', 's')->addSelect('s')
            ->leftJoin('g.prelevement', 'p')->addSelect('p')
            ->leftJoin('g.conditionnementImmunologique', 'c')->addSelect('c')
            ->andWhere('g.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     *  Vérifier si un rang existe déjà dans un dossier
     */
    public function existsByDossierAndRang(DossierMedical $dossier, int $rang): bool
    {
        return (bool) $this->createQueryBuilder('g')
            ->select('1')
            ->andWhere('g.dossierMedical = :dossier')
            ->andWhere('g.rangGreffe = :rang')
            ->setParameter('dossier', $dossier)
            ->setParameter('rang', $rang)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     *  Compter les greffes d’un dossier
     */
    public function countByDossier(DossierMedical $dossier): int
    {
        return (int) $this->createQueryBuilder('g')
            ->select('COUNT(g.id)')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     *  Récupérer la dernière greffe (la plus récente)
     */
    public function findLastGreffeByDossier(DossierMedical $dossier): ?Greffe
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier)
            ->orderBy('g.dateGreffe', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     *  Liste optimisée pour API (light)
     */
    public function findListForApi(DossierMedical $dossier): array
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.dateGreffe, g.rangGreffe, g.typeGreffe, g.greffonFonctionnel')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier)
            ->orderBy('g.dateGreffe', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     *  (OPTIONNEL) Filtrer les greffes
     */
    public function findByDossierWithFilters(DossierMedical $dossier, array $filters): array
    {
        $qb = $this->createQueryBuilder('g')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier);

        if (!empty($filters['type'])) {
            $qb->andWhere('g.typeGreffe = :type')
               ->setParameter('type', $filters['type']);
        }

        if (isset($filters['fonctionnel'])) {
            $qb->andWhere('g.greffonFonctionnel = :fonctionnel')
               ->setParameter('fonctionnel', $filters['fonctionnel']);
        }

        if (!empty($filters['dateFrom'])) {
            $qb->andWhere('g.dateGreffe >= :dateFrom')
               ->setParameter('dateFrom', $filters['dateFrom']);
        }

        if (!empty($filters['dateTo'])) {
            $qb->andWhere('g.dateGreffe <= :dateTo')
               ->setParameter('dateTo', $filters['dateTo']);
        }

        return $qb
            ->orderBy('g.dateGreffe', 'ASC')
            ->getQuery()
            ->getResult();
    }
}