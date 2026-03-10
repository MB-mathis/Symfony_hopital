<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Création de l'utilisateur admin de test
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_USER']);

        // Hashage du mot de passe "test"
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'test');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}