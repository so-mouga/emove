<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $roles = ['ROLE_SELLER', 'ROLE_USER'];
        $users = [
            [
                'email'     =>  'kevin@gmail.com',
                'role'     =>  ['ROLE_ADMIN'],
            ],
            [
                'email'     =>  'paul@gmail.com',
                'role'     =>  ['ROLE_ADMIN'],
            ],
            [
                'email'     =>  'ema@gmail.com',
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

        for ($i = 0; $i <= 100; $i++) {
            $user = new User();
            $user->setFirstName('first name'.$i);
            $user->setLastName('last name'.$i);
            $user->setBirthday(new \DateTime('01/01/1990'));
            $user->setAdresse('22 rue test');
            $user->setPostalCode('75015');
            $user->setPhone('0666908544');
            $user->setPermis(new \DateTime('01/01/1990'));
            $user->setRoles([$roles[array_rand($roles, 1)]]);
            $user->setEmail(sprintf('ipssi%s@gmail.com', $i));
            $user->setPassword($this->encoder->encodePassword($user, 'admin'));
            $user->setAgency($this->getReference(AgencyFixtures::AGENCY_REFERENCE.mt_rand(1, 200)));

            $manager->persist($user);
        }

        $manager->flush();

    }
}
