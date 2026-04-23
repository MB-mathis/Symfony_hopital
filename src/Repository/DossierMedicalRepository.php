<?php

namespace App\Repository;

use App\Entity\DossierMedical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Patient;

/**
 * @extends ServiceEntityRepository<DossierMedical>
 */
class DossierMedicalRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, DossierMedical::class);
    }

//    /**
//     * @return DossierMedical[] Returns an array of DossierMedical objects
//     */
    public function findByPatient(Patient $patient): ?DossierMedical
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.patient = :patient')
            ->setParameter('patient', $patient)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countDossiers(): int
    {
         return $this->createQueryBuilder('d')
              ->select('COUNT(d.id)')
              ->getQuery()
              ->getSingleScalarResult();
    }

    public function findFullByPatient(Patient $patient): ?DossierMedical
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.greffes', 'g')      // lier les greffes
            ->addSelect('g')
            ->leftJoin('g.donneur', 'donneur') // lier les donneurs
            ->addSelect('donneur')
            ->where('d.patient = :patient')
            ->setParameter('patient', $patient)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
