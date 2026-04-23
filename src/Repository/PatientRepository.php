<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
/**
 * @extends ServiceEntityRepository<Patient>
 */
class PatientRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Patient::class);
    }

   /**
    * @return Patient[] Returns an array of Patient objects
    */

   public function countPatients(): int
    {
         return $this->createQueryBuilder('p')
              ->select('COUNT(p.id)')
              ->getQuery()
              ->getSingleScalarResult();
    }
    
     /**
      * Récupérer les patients créés par un utilisateur ou partagés avec lui
      * @return Patient[]
      */
   public function findPatientsByUser(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.patientUserShares', 'pus') // jointure avec PatientUserShare
            ->andWhere('p.createdBy = :user OR pus.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.createdAt', 'DESC') // ou createdAt si tu veux
            ->distinct()
            ->getQuery()
            ->getResult();
    }


}
