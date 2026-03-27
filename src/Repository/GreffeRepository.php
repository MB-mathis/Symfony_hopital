<?php

namespace App\Repository;

use App\Entity\Greffe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\DossierMedical;

/**
 * @extends ServiceEntityRepository<Greffe>
 */
class GreffeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Greffe::class);
    }

   /**
    * @return Greffe[] Returns an array of Greffe objects
    */
    // public function findGreffeByUser(User $user): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.createdBy = :user')
    //         ->setParameter('user', $user)
    //         ->orderBy('p.id', 'DESC') // ou createdAt si tu l’as
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findByDossier(DossierMedical $dossier): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.dossierMedical = :dossier')
            ->setParameter('dossier', $dossier)
            ->orderBy('g.rangGreffe', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
