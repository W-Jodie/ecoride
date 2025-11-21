<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\Car;
use App\Entity\Carpooling;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTimeImmutable;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = [];
        $cars = [];
        $carpoolings = [];

        // 🧍 20 Utilisateurs + Wallet
        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(true);
            $user->setAdress($faker->address());
            $user->setDateBirthdayAt(new DateTimeImmutable($faker->date()));
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));

            // 💰 Wallet relié à l'utilisateur
            $wallet = new Wallet();
            $wallet->setUser($user);
            $wallet->setCredit($faker->randomFloat(2, 20, 1000));         // entre 20 et 1000 €
            $wallet->setPendingCredit($faker->randomFloat(2, 0, 300));    // entre 0 et 300 €
            $manager->persist($wallet);

            $manager->persist($user);
            $users[] = $user;
        }

        // 🚗 20 Voitures
        for ($i = 1; $i <= 20; $i++) {
            $car = new Car();
            $car->setBrand($faker->randomElement(['Tesla', 'Peugeot', 'Renault', 'Toyota', 'BMW', 'Citroën']));
            $car->setModel($faker->word());
            $car->setLicensePlate(strtoupper($faker->bothify('??-###-??')));
            $car->setIsElectric($faker->boolean(40)); // 40% électriques
            $car->setOwner($faker->randomElement($users));

            $manager->persist($car);
            $cars[] = $car;
        }

        for ($i = 1; $i <= 20; $i++) {
            $carpooling = new Carpooling();
            $carpooling->setCar($faker->randomElement($cars));
            $carpooling->setDriver($faker->randomElement($users));
            $carpooling->setDeparture($faker->city());
            $carpooling->setArrival($faker->city());

            $departureAt = new DateTimeImmutable('+' . mt_rand(1, 10) . ' days');
            $arrivalAt = $departureAt->modify('+' . mt_rand(1, 5) . ' hours');

            $carpooling->setDepartureAt($departureAt);
            $carpooling->setArrivalAt($arrivalAt);
            $carpooling->setPrice($faker->randomFloat(2, 5, 50));
            $carpooling->setStatus($faker->randomElement(['En attente', 'Confirmé', 'Terminé']));
            $carpooling->setIsEcoTrip($i <= 10); // Les 10 premiers sont éco

            $manager->persist($carpooling);
            $carpoolings[] = $carpooling;
        }

        // 🧾 40 Réservations (passager différent du conducteur)
        foreach (range(1, 40) as $i) {
            $reservation = new Reservation();

            $carpooling = $faker->randomElement($carpoolings);

            $driver = $carpooling->getDriver();

            $passenger = $faker->randomElement(
                array_filter($users, fn($u) => $u !== $driver)
            );

            $reservation->setDriver($driver);
            $reservation->setPassenger($passenger);
            $reservation->setCarpooling($carpooling);

            $reservation->setTotalPrice($carpooling->getPrice());

            $reservation->setStatus($faker->randomElement(['Confirmé', 'Terminé', 'Annulé']));

            $manager->persist($reservation);
                        }

                $manager->flush();
            }
}
