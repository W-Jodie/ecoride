<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Car;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class CarFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Initialisation de Faker (français)
        $faker = Factory::create('fr_FR');

        // --- Création d’un utilisateur "propriétaire" ---
        $user = new User();
        $user->setEmail('user1@email.fr');
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName($faker->firstName());
        $user->setLastName($faker->lastName());
        $user->setIsVerified(true);
        $user->setDateBirthdayAt(new \DateTimeImmutable('1990-01-01'));

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'User1@1234');
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        // --- Création de plusieurs voitures ---
        for ($i = 0; $i < 100; $i++) {
            $car = new Car();
            $car->setBrand($faker->randomElement(['Toyota', 'Peugeot', 'Renault', 'Tesla', 'Volkswagen', 'BMW', 'Citroën']));
            $car->setModel($faker->word());
            $car->setLicensePlate(strtoupper($faker->bothify('??-###-??')));
            $car->setIsElectric($faker->boolean(30)); // 30% de chances d'être électrique
            $car->setOwner($user);

            $manager->persist($car);
        }

        // Enregistrement en base
        $manager->flush();
    }
}
