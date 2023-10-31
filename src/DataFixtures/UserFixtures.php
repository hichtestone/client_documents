<?php

namespace App\DataFixtures;

use App\Entity\CompanyInterne;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;

    }
    public function load(ObjectManager $manager)
    {
        // fixture companiesInterne

        $companyInterne= new CompanyInterne();
        $companyInterne->setName("Altra Systems");
        $companyInterne->setEmail("info@altra-systems.com");
        $companyInterne->setAdresse("12 Avenue Emile Aillaud");
        $companyInterne->setCity("france");
        $companyInterne->setCountry("Grigny");
        $companyInterne->setZipcode(91350);
        $companyInterne->setLogo("altra system.png");
        $companyInterne->setCreatedAt(new \DateTime());
        $companyInterne->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($companyInterne);
        $this->addReference('companyAltra', $companyInterne);
        $companyInterne1= new CompanyInterne();
        $companyInterne1->setName("IDS groupe");
        $companyInterne1->setEmail("commercial@ids-groupe.com");
        $companyInterne1->setAdresse("8 av Emile Aillaud – 91350 GRIGNY");
        $companyInterne1->setCity("france");
        $companyInterne1->setCountry("Grigny");
        $companyInterne1->setLogo("idsgroupe.png");
        $companyInterne1->setZipcode(91350);
        $companyInterne1->setCreatedAt(new \DateTime());
        $companyInterne1->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($companyInterne1);
        $this->addReference('companyIds', $companyInterne1);

        //fixture SUPER_ADMIN

        $user =new User();
        $encodedPassword = $this->encoder->hashPassword($user, "altra2021");
        $user->setEmail("SuperAdmin@Altra.com");
        $user->setPassword($encodedPassword);
        $user->setUserName("SuperAdmin");
        $user->setIsAdmin(1);
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $manager->persist($user);

        //Fixture ADMIN_ALTRA

        $user1 =new User();
        $encodedPassword = $this->encoder->hashPassword($user1, "altra2021");
        $user1->setEmail("AdminAltra@Altra.com");
        $user1->setPassword($encodedPassword);
        $user1->setUserName("AdminAltra");
        $user1->setIsAdmin(1);
        $user1->setRoles(["ROLE_ADMIN_ALTRA"]);
        $user1->setCompanyInterne($companyInterne);
        $manager->persist($user1);

        //Fixture ADMIN_IDS

        $user2 =new User();
        $encodedPassword = $this->encoder->hashPassword($user2, "altra2021");
        $user2->setEmail("AdminIDS@Altra.com");
        $user2->setPassword($encodedPassword);
        $user2->setUserName("AdminIDS");
        $user2->setIsAdmin(1);
        $user2->setRoles(["ROLE_ADMIN_IDS"]);
        $user2->setCompanyInterne($companyInterne1);
        $manager->persist($user2);

        $manager->flush();
    }
}
