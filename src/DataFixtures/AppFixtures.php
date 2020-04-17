<?php

namespace App\DataFixtures;


use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Champion;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		
		$faker = Factory::create('fr_FR');
		

		for ($i=1; $i < 30; $i++) { 

			$ad = new Ad();

			$title 			= $faker->sentence(); 
			$coverImage 	= $faker->imageUrl(1000,350);
			$introduction	= $faker->paragraph(2);
			$contenu 		= '<p>' . join('</p><p>',$faker->paragraphs(5)) . '</p>';


			$ad->setTitle($title)
					->setIntroduction($introduction)
					->setContent($contenu)
					->setCoverImage($coverImage)
					->setPrice(mt_rand(40,200))
					->setRooms(mt_rand(1,5));
			$manager->persist($ad);

			for ($j=1; $j < mt_rand(2,5) ; $j++) { 
				$image = new Image();

				$image->setUrl($faker->imageUrl())
					->setCaption($faker->sentence())
					->setAd($ad);
				$manager->persist($image);
				
			}
		}
		$manager->flush();
	}
}
