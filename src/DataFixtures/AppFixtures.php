<?php

namespace App\DataFixtures;


use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Role;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Champion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

	public function load(ObjectManager $manager)
	{
		
		$faker = Factory::create('fr_FR');

		// Ajout des roles admin dans la base
		$adminRole = new Role();
		$adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        //Création de l'utilisateur admin
        $adminUser = new User();
        $adminUser->setFirstName('Lilian')
                ->setLastName('dorazio')
                ->setEmail('lilian@symfony.com')
                ->setHash($this->encoder->encodePassword($adminUser,'password'))
                ->setPicture('https://avatars.io/twitter/liiorC')
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>',$faker->paragraphs(3)) . '</p>')
                ->addUserRole($adminRole)
            ;
        $manager->persist($adminUser);

        $users = [];
		$genres = ['male', 'female'];
		
		//Nous gérons les utilisateurs
		for ($i=1; $i <= 10; $i++) { 
			$user = new User();

			$genre = $faker->randomElement($genres);

			$picture = "https://randomuser.me/api/portraits/";
			$pictureId = $faker->numberBetween(1,99) . '.jpg';

			$picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

			$hash = $this->encoder->encodePassword($user, 'password');


			$user->setEmail($faker->email)
				->setFirstName($faker->firstName($genre))
				->setLastName($faker->lastName)
				->setIntroduction($faker->sentence())
				->setDescription('<p>' . join('</p><p>',$faker->paragraphs(3)) . '</p>')
				->setHash($hash)
				->setPicture($picture)
			;
			$manager->persist($user);

			$users[] = $user;
		}
		
		// Nous gérons les annonces
		for ($i=1; $i < 30; $i++) { 

			$ad = new Ad();

			$title 			= $faker->sentence(); 
			$coverImage 	= $faker->imageUrl(1000,350);
			$introduction	= $faker->paragraph(2);
			$contenu 		= '<p>' . join('</p><p>',$faker->paragraphs(5)) . '</p>';
			$user     		= $users[mt_rand(0, count($users) - 1)];


			$ad->setTitle($title)
					->setIntroduction($introduction)
					->setContenu($contenu)
					->setCoverImage($coverImage)
					->setPrice(mt_rand(40,200))
					->setRooms(mt_rand(1,5))
					->setAuthor($user)
				;
			$manager->persist($ad);
			

			//Nous gérons les images des annonces
			for ($j=1; $j < mt_rand(2,5) ; $j++) { 
				$image = new Image();

				$image->setUrl($faker->imageUrl())
					->setCaption($faker->sentence())
					->setAd($ad);
				$manager->persist($image);
			}

			//Gestion des réservations
            for ($j = 1; $j < mt_rand(0,10);$j++){
                $booking = new Booking();

                //Creation des donnée avec Faker
                $createdAt  = $faker->dateTimeBetween('-6 months');
                $startDate  = $faker->dateTimeBetween("-3 months");

                $duration   = mt_rand(3,10);
                $endDate    = (clone $startDate)->modify("+$duration days");
                $amout      = $ad->getPrice() * $duration;

                $booker     = $users[mt_rand(0, count($users) - 1)];
                $comment    = $faker->paragraph();

                $booking->setBooker($booker)
                        ->setAd($ad)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setCreateAt($createdAt)
                        ->setAmount($amout)
                        ->setComment($comment)
                ;

                $manager->persist($booking);
            }
		}
		
		$manager->flush();
	}
}
