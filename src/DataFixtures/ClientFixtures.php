<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\CompanyInterne;
use App\Entity\Equipement;
use App\Entity\Infrastructure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;

    }

    public function load(ObjectManager $manager)
    {
        $companyInterne=$this->getReference('companyAltra');
        $companyInterne1=$this->getReference('companyIds');
        $company=new Company();
        $company->setName("DELL");
        $company->setEmail("DELL@gmail.com");
        $company->setAdresse("delladresse");
        $manager->persist($company);

        $company1=new Company();
        $company1->setName("HP");
        $company1->setEmail("HP@gmail.com");
        $company1->setAdresse("ḦP adresse");
        $manager->persist($company1);
        $file = 'public/uploads/DB/LISTE CLIENTS IDS.xlsx';
        $file1='public/uploads/DB/LISTE CLIENTS ALTRA.xlsx';


        // liste client IDS
        if ( $xlsx = \SimpleXLSX::parse($file) ) {

            foreach( $xlsx->rows() as $key=> $r ) {
                for($longeur_pass=10,$pass='';strlen($pass)<$longeur_pass;$pass.=chr(!mt_rand(0,2)? mt_rand(48,57):(!mt_rand(0,1)?mt_rand(65,90):mt_rand(97,122))));

                $client= new Client();
                $encodedPassword = $this->encoder->hashPassword($client, $pass);
                $client->setPassword($encodedPassword);
                $client->setFirstName($r[0]);
                $client->setLastName($r[0]);
                $client->setCompanyInterne($companyInterne1);
                $client->setAdresse("my adresse");
                $client->setPhone("123456789");
                $client->setEmail("mayemail@gmail.com");
                $manager->persist($client);
            }

        }
        else{
            dd( \SimpleXLSX::parseError());
        }

       // liste client ALTRA

        if ( $xlsx = \SimpleXLSX::parse($file1) ) {

            foreach( $xlsx->rows() as $key=> $r ) {
                for($longeur_pass=10,$pass='';strlen($pass)<$longeur_pass;$pass.=chr(!mt_rand(0,2)? mt_rand(48,57):(!mt_rand(0,1)?mt_rand(65,90):mt_rand(97,122))));

                $client= new Client();
                $encodedPassword = $this->encoder->hashPassword($client, $pass);
                $client->setPassword($encodedPassword);
                $client->setFirstName($r[0]);
                $client->setLastName($r[0]);
                $client->setCompanyInterne($companyInterne);
                $client->setAdresse("my adresse");
                $client->setPhone("123456789");
                $client->setEmail("myemailaltra@gmail.com");
                $manager->persist($client);
                if($r[0]=="ARNAUD MARIN"){
                    $fileinfra='public/uploads/DB/Serveurs MARIN.xlsx';
                    if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {

                        foreach( $xlsxi->rows() as $key=> $r ) {
                            $infrastructure= new Infrastructure();
                            $infrastructure->setClient($client);
                            $infrastructure->setSite($r[0]);

                             if($r[1]!="")
                               $infrastructure->setNomSvr($r[1]);
                               if($r[2]!="")
                               $infrastructure->setOS($r[2]);
                               if($r[3]!="")
                               $infrastructure->setCPUPROC($r[3]);
                               if($r[4]!="")
                               $infrastructure->setRAM($r[4]);
                               if($r[5]!="")
                               $infrastructure->setTotalDisque($r[5]);
                               if($r[6]!="")
                                 $infrastructure->setDisqueUsed($r[6]);
                               if($r[7]!="")
                                 $infrastructure->setIP($r[7]);
                               if($r[8]!="")
                                 $infrastructure->setHYPERV($r[8]);
                               if($r[9]!="")
                                 $infrastructure->setNominal($r[9]);
                            $manager->persist($infrastructure);

                        }
                    }else{
                        dd($fileinfra);

                        dd('infra ' .$fileinfra. \SimpleXLSX::parseError());
                        continue;
                    }

                }
                elseif($r[0]=="FIDEXIA"){
                    $fileinfra='public/uploads/DB/Inventaire fidexia.xlsx';
                    if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {

                        foreach( $xlsxi->rows() as $key=> $r ) {
                            $infrastructure= new Infrastructure();
                            $infrastructure->setClient($client);
                            $infrastructure->setSite($r[0]);

                             if($r[1]!="")
                               $infrastructure->setNomSvr($r[1]);
                               if($r[2]!="")
                               $infrastructure->setOS($r[2]);
                               if($r[3]!="")
                               $infrastructure->setCPUPROC($r[3]);
                               if($r[4]!="")
                               $infrastructure->setRAM($r[4]);
                               if($r[5]!="")
                               $infrastructure->setTotalDisque($r[5]);
                               if($r[6]!="")
                                 $infrastructure->setDisqueUsed($r[6]);
                               if($r[7]!="")
                                 $infrastructure->setIP($r[7]);
                               if($r[8]!="")
                                 $infrastructure->setHYPERV($r[8]);
                               if($r[9]!="")
                                 $infrastructure->setNominal($r[9]);
                            $manager->persist($infrastructure);

                        }
                    }else{
                        dd($fileinfra);

                        dd('infra ' .$fileinfra. \SimpleXLSX::parseError());
                        continue;
                    }
                }
                elseif($r[0]=="SCTM"){
                    $fileinfra='public/uploads/DB/Inventaire STCM-APSM.xlsx';
                    if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {

                        foreach( $xlsxi->rows() as $key=> $r ) {
                            $infrastructure= new Infrastructure();
                            $infrastructure->setClient($client);
                            $infrastructure->setSite($r[0]);

                              if($r[1]!="")
                               $infrastructure->setNomSvr($r[1]);
                               if($r[2]!="")
                               $infrastructure->setOS($r[2]);
                               if($r[3]!="")
                               $infrastructure->setCPUPROC($r[3]);
                               if($r[4]!="")
                               $infrastructure->setRAM($r[4]);
                               if($r[5]!="")
                               $infrastructure->setTotalDisque($r[5]);
                               if($r[6]!="")
                                 $infrastructure->setDisqueUsed($r[6]);
                               if($r[7]!="")
                                 $infrastructure->setIP($r[7]);
                               if($r[8]!="")
                                 $infrastructure->setHYPERV($r[8]);
                               if($r[9]!="")
                                 $infrastructure->setNominal($r[9]);
                            $manager->persist($infrastructure);

                        }
                    }else{
                        dd($fileinfra);

                        dd('infra ' .$fileinfra. \SimpleXLSX::parseError());
                        continue;
                    }
                }elseif($r[0]=="FERLAM"){
                    $fileinfra='public/uploads/DB/INVENTAIRE FERLAM.xlsx';
                    if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {

                        foreach( $xlsxi->rows() as $key=> $r ) {
                            $infrastructure= new Infrastructure();
                            $infrastructure->setClient($client);
                            $infrastructure->setSite($r[0]);

                             if($r[1]!="")
                               $infrastructure->setNomSvr($r[1]);
                               if($r[2]!="")
                               $infrastructure->setOS($r[2]);
                               if($r[3]!="")
                               $infrastructure->setCPUPROC($r[3]);
                               if($r[4]!="")
                               $infrastructure->setRAM($r[4]);
                               if($r[5]!="")
                               $infrastructure->setTotalDisque($r[5]);
                               if($r[6]!="")
                                 $infrastructure->setDisqueUsed($r[6]);
                               if($r[7]!="")
                                 $infrastructure->setIP($r[7]);
                               if($r[8]!="")
                                 $infrastructure->setHYPERV($r[8]);
                               if($r[9]!="")
                                 $infrastructure->setNominal($r[9]);
                            $manager->persist($infrastructure);

                        }
                    }else{
                        dd($fileinfra);

                        dd('infra ' .$fileinfra. \SimpleXLSX::parseError());
                        continue;
                    }

                }elseif ($r[0]=="PROTERRA"){
                    $fileinfra='public/uploads/DB/Inventaire Proterra.xlsx';
                    if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {

                        foreach( $xlsxi->rows() as $key=> $r ) {
                            $infrastructure= new Infrastructure();
                            $infrastructure->setClient($client);
                            $infrastructure->setSite($r[0]);

                              if($r[1]!="")
                               $infrastructure->setNomSvr($r[1]);
                               if($r[2]!="")
                               $infrastructure->setOS($r[2]);
                               if($r[3]!="")
                               $infrastructure->setCPUPROC($r[3]);
                               if($r[4]!="")
                               $infrastructure->setRAM($r[4]);
                               if($r[5]!="")
                               $infrastructure->setTotalDisque($r[5]);
                               if($r[6]!="")
                                 $infrastructure->setDisqueUsed($r[6]);
                               if($r[7]!="")
                                 $infrastructure->setIP($r[7]);
                               if($r[8]!="")
                                 $infrastructure->setHYPERV($r[8]);
                               if($r[9]!="")
                                 $infrastructure->setNominal($r[9]);
                            $manager->persist($infrastructure);

                        }
                    }else{
                        dd($fileinfra);

                        dd('infra ' .$fileinfra. \SimpleXLSX::parseError());
                        continue;
                    }

                }else{
                    $fileinfra='public/uploads/DB/aucun.xlsx';

                }

            }

        }
        else{
            dd( \SimpleXLSX::parseError());
        }




        $manager->flush();
    }


    public function getDependencies()
    {
        return [

            UserFixtures::class,

        ];
    }

    public static function getGroups(): array
    {
        return [ 'user'];
    }
}
