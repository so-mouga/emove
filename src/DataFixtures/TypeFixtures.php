<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public const TYPE_REFERENCE = 'type';
    public const TYPE_SCOOTER_REFERENCE = 'type-scooter';

    public function load(ObjectManager $manager)
    {
        $typesCar = [
            [
                'name'     =>  'car',
                'category' =>  'economique',
            ],
            [
                'name'     =>  'car',
                'category' =>  'compact',
            ],
            [
                'name'     =>  'car',
                'category' =>  'moyenne',
            ],
            [
                'name'     =>  'car',
                'category' =>  'grande',
            ]
        ];

        $i = 1;
        foreach ($typesCar as $oneType){
            $type = new Type();
            $type->setName($oneType['name']);
            $type->setCategory($oneType['category']);
            $this->addReference(self::TYPE_REFERENCE.$i, $type);
            $manager->persist($type);
            $i++;
        }

        $typeScooter = new Type();
        $typeScooter->setName('scooter');
        $this->addReference(self::TYPE_SCOOTER_REFERENCE, $type);
        $manager->persist($typeScooter);

        $manager->flush();
    }
}
