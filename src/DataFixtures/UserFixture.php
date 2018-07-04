<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'email'     =>  'kevin@gmail.com',
                'role'     =>  ['ROLE_ADMIN'],
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
            $user->setPassword($this->encoder->encodePassword($user, 'admin'));


            $manager->persist($user);
        }
        $manager->flush();

    }
}
