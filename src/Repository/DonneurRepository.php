<?php

namespace App\Repository;

use App\Entity\Donneur;
use App\Model\DonneurTemplate;
use App\Enum\TypeDonneur;
use App\Enum\GroupeSanguin;
use App\Enum\Sexe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Donneur>
 */
class DonneurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donneur::class);
    }

    public function countDonneurs(): int
    {
         return $this->createQueryBuilder('d')
              ->select('COUNT(d.id)')
              ->getQuery()
              ->getSingleScalarResult();
    }


    /** @return Donneur[] */
    public function findAllDonneurs(): array
    {
        return $this->findAll();
    }

    public function findDonneurById(int $id): ?Donneur
    {
        return $this->find($id);
    }

    public function findDonneurByNumeroCrista(string $numeroCrista): ?Donneur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.numeroCrista = :numero')
            ->setParameter('numero', $numeroCrista)
            ->getQuery()
            ->getOneOrNullResult();
    }

   

    /** @return Donneur[] */
    public function findDonneursByGroupeSanguin(GroupeSanguin $groupe): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.groupeSanguin = :groupe')
            ->setParameter('groupe', $groupe)
            ->getQuery()
            ->getResult();
    }

    /** @return Donneur[] */
    public function findDonneursBySexe(Sexe $sexe): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.sexe = :sexe')
            ->setParameter('sexe', $sexe)
            ->getQuery()
            ->getResult();
    }



    /** @return Donneur[] */
    public function findDonneursByType(TypeDonneur|string $type): array
    {
        // supporte l'enum ou la string (vivant/decede)
        if ($type instanceof TypeDonneur) {
            $type = $type->value;
        }

        return $this->createQueryBuilder('d')
            ->andWhere('d.typeDonneur = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    /** @return Donneur[] */
    public function findDonneursVivant(): array
    {
        return $this->findDonneursByType(DonneurTemplate::KEY_VIVANT);
    }

    /** @return Donneur[] */
    public function findDonneursDecede(): array
    {
        return $this->findDonneursByType(DonneurTemplate::KEY_DECEDE);
    }

    /** @return Donneur[] */
    public function findDonneursWithPrelevement(): array
    {
        $key = DonneurTemplate::KEY_PRELEVEMENT;

        return $this->createQueryBuilder('d')
            ->andWhere("JSON_LENGTH(d.data->'\$.{$key}') > 0")
            ->getQuery()
            ->getResult();
    }

    /** @return Donneur[] */
    public function findDonneursWithGreffes(): array
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.greffes', 'g')
            ->addSelect('g')
            ->getQuery()
            ->getResult();
    }
}