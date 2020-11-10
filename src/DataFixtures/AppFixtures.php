<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $manager;
    private $faker;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {

        $this->encoder=$encoder;

    }

    /**
     * 
     * création des clients
     * 
     * @return void
     * 
     * 
     */
    public function load(ObjectManager $manager)
    {
        $client1 = new Client();
        $client1->setName("Mark Tel")
                ->setEmail("essonoadou@gmail.com")
                ->setPassword($this->encoder->encodePassword($client1, $client1->getName()));
        $manager->persist($client1);
        
        
        
        $client2 = new Client();
        $client2->setName("Iphone Store")
            ->setEmail("essono237@gmail.com")
            ->setPassword($this->encoder->encodePassword($client2, $client2->getName()));
        $manager->persist($client2);
                
                
        $client3 = new Client();
        $client3->setName("Iphone Place")
            ->setEmail("steve237@gmail.com")
            ->setPassword($this->encoder->encodePassword($client3, $client3->getName()));
        $manager->persist($client3);
                    
                    
        $client4 = new Client();
        $client4->setName("Iphone Place")
            ->setEmail("steve237@gmail.com")
            ->setPassword($this->encoder->encodePassword($client4, $client4->getName()));
        $manager->persist($client4);


        $user1 = new Users();
        $user1->setName("John")
                ->setEmail("michel45@gmail.com")
                ->setClient($client1);
        $manager->persist($user1);


        $user2 = new Users();
        $user2->setName("Christian")
                ->setEmail("Samy54@gmail.com")
                ->setClient($client2);
        $manager->persist($user2);

        $user3 = new Users();
        $user3->setName("Pierre")
                ->setEmail("Samy54@gmail.com")
                ->setClient($client3);
        $manager->persist($user3);

        $user4 = new Users();
        $user4->setName("Steve")
                ->setEmail("adouessono@yahoo.fr")
                ->setClient($client4);
        $manager->persist($user4);
        
        
        
        $manager->flush();
    
    }



















}
