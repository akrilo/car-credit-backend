<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Entity\Brand;
use App\Domain\Entity\Car;
use App\Domain\Entity\CarModel;
use App\Domain\Entity\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $toyota = new Brand();
        $toyota->setName('Toyota');
        $manager->persist($toyota);

        $bmw = new Brand();
        $bmw->setName('BMW');
        $manager->persist($bmw);

        $corolla = new CarModel();
        $corolla->setName('Corolla');
        $manager->persist($corolla);

        $camry = new CarModel();
        $camry->setName('Camry');
        $manager->persist($camry);

        $series3 = new CarModel();
        $series3->setName('3 Series');
        $manager->persist($series3);

        $car1 = new Car();
        $car1->setBrand($toyota);
        $car1->setModel($corolla);
        $car1->setPhoto('https://example.com/photos/toyota_corolla.jpg');
        $car1->setPrice(1000000);
        $manager->persist($car1);

        $car2 = new Car();
        $car2->setBrand($toyota);
        $car2->setModel($camry);
        $car2->setPhoto('https://example.com/photos/toyota_camry.jpg');
        $car2->setPrice(1500000);
        $manager->persist($car2);

        $car3 = new Car();
        $car3->setBrand($bmw);
        $car3->setModel($series3);
        $car3->setPhoto('https://example.com/photos/bmw_3series.jpg');
        $car3->setPrice(2500000);
        $manager->persist($car3);

        $program1 = new CreditProgram();
        $program1->setTitle('Alfa Energy');
        $program1->setInterestRate(12.3);
        $manager->persist($program1);

        $program2 = new CreditProgram();
        $program2->setTitle('Beta Energy');
        $program2->setInterestRate(14.5);
        $manager->persist($program2);


        $program3 = new CreditProgram();
        $program3->setTitle('Gamma Energy');
        $program3->setInterestRate(10.2);
        $manager->persist($program3);

        $manager->flush();
    }
}
