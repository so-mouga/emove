<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AgencyFixtures extends Fixture
{
    public const AGENCY_REFERENCE = 'agency';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 200; $i++) {
            $agency = new Agency();
            $agency->setName('Agency'.$i);
            $agency->setCity('City'.$i);
            $agency->setPostalCode(sprintf('%s%s0%s%s', mt_rand(1, 9), mt_rand(1, 9), mt_rand(1, 9), mt_rand(1, 9)));
            $this->addReference(self::AGENCY_REFERENCE.$i, $agency);
            $manager->persist($agency);
        }

        $manager->flush();
    }
}
