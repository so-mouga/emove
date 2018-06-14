<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'email'     =>  'kevin@gmail.com',
                'role'     =>  ['ROLE_SELLER'],
            ],
            [
                'email'     =>  'lucille@gmail.com',
                'role'     =>  ['ROLE_USER'],
            ],
            [
                'email'     =>  'nasser@gmail.com',
                'role'     =>  ['ROLE_SELLER'],
            ],
            [
                'email'     =>  'Paul@gmail.com',
                'role'     =>  ['ROLE_ADMIN'],
            ],
        ];

        foreach ($users as $oneUser){

            $user = new User();
            $user->setFirstName('first name');
            $user->setLastName('last name');
            $user->setBirthday(new \DateTime('01/01/1990'));
            $user->setAdresse('22 rue test');
            $user->setPostalCode('75015');
            $user->setPhone('0666908544');
            $user->setPermis(new \DateTime('01/01/1990'));
            $user->setRoles($oneUser['role']);
            $user->setEmail($oneUser['email']);
            $user->setPassword('admin');


            $manager->persist($user);
        }
        $manager->flush();

    }
}
