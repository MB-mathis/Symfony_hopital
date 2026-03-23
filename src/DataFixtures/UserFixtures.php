<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture 
{
    private const PASSWORD = 'test';

    private array $usersData = [
        [
            'reference' => 'user_admin',
            'email' => 'admin@example.com',
            'nom' => 'Admin',
            'prenom' => 'Principal',
            'roles' => ['ROLE_ADMIN'],
        ],
        [
            'reference' => 'user_super_admin',
            'email' => 'superadmin@example.com',
            'nom' => 'Super',
            'prenom' => 'Admin',
            'roles' => ['ROLE_SUPER_ADMIN'],
        ],
        [
            'reference' => 'user_medical',
            'email' => 'medecin@example.com',
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'roles' => ['ROLE_MEDICAL'],
        ],
        [
            'reference' => 'user_nephrologue',
            'email' => 'nephrologue@example.com',
            'nom' => 'Martin',
            'prenom' => 'Claire',
            'roles' => ['ROLE_NEPHROLOGUE'],
        ],
    ];

    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        foreach ($this->usersData as $u) {
            $user = new User();
            $user->setEmail($u['email'])
                 ->setNom(strtoupper($u['nom']))
                 ->setPrenom($u['prenom'])
                 ->setRoles(array_unique($u['roles']))
                 ->setPassword($this->passwordHasher->hashPassword($user, self::PASSWORD));

            $manager->persist($user);
            $this->addReference($u['reference'], $user);
        }

        // Flush unique → meilleure performance
        $manager->flush();
    }
}