<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brands = [
            'Audi', 'BMW', 'Citroën',
            'Fiat', 'Ford', 'Mercedes',
            'Mini', 'Nissan', 'Opel',
            'Peugeot', 'Renault', 'Toyota',
            'Volkswagen', 'Volvo', 'Skoda',
        ];
        $colors = [
            'Noir', 'Rouge', 'Gris', 'Vert', 'Jaune', 'Bleu', 'Blanc'
        ];
        $nbDoors = ['3', '5'];
        $nbSeets = ['4', '5', '7', '2'];
        $vehicleConditions = ['neuf', 'comme neuf', 'trace d\'usure', 'occasion'];

        for ($i = 0; $i <= 500; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand($brands[array_rand($brands, 1)]);
            $vehicle->setAgency($this->getReference(AgencyFixtures::AGENCY_REFERENCE.mt_rand(1, 200)));
            $vehicle->setColor($colors[array_rand($colors, 1)]);
            $vehicle->setIndexPrice(mt_rand(50, 400));
            $vehicle->setMileage(mt_rand(0, 200000));
            $vehicle->setModel('model'.mt_rand(1, 10));
            $vehicle->setNbDoors($nbDoors[array_rand($nbDoors, 1)]);
            $vehicle->setNbSeets($nbSeets[array_rand($nbSeets, 1)]);
            $vehicle->setNumberPlate(sprintf('AB-%s-CA', mt_rand(100, 999)));
            $vehicle->setVehiculeCondition($vehicleConditions[array_rand($vehicleConditions, 1)]);
            $vehicle->setType($this->getReference(TypeFixtures::TYPE_REFERENCE.mt_rand(1, 4)));

            $manager->persist($vehicle);
        }

        for ($i = 0; $i <= 100; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand($brands[array_rand($brands, 1)]);
            $vehicle->setAgency($this->getReference(AgencyFixtures::AGENCY_REFERENCE.mt_rand(1, 200)));
            $vehicle->setColor($colors[array_rand($colors, 1)]);
            $vehicle->setIndexPrice(mt_rand(50, 400));
            $vehicle->setMileage(mt_rand(0, 200000));
            $vehicle->setModel('model'.mt_rand(1, 10));
            $vehicle->setNbDoors(0);
            $vehicle->setNbSeets(0);
            $vehicle->setNumberPlate(sprintf('AB-%s-CA', mt_rand(100, 999)));
            $vehicle->setVehiculeCondition($vehicleConditions[array_rand($vehicleConditions, 1)]);
            $vehicle->setType($this->getReference(TypeFixtures::TYPE_SCOOTER_REFERENCE));

            $manager->persist($vehicle);
        }

        $manager->flush();
    }
}
