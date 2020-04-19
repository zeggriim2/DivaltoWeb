<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{

	/**
	 * Permet d'avoir la configuration de base d'un champ
	 *
	 * @param string $label
	 * @param string $placeholder
	 * @return array
	 */
	private function getConfiguration($label, $placeholder) :array {
		return [
				'label' => $label, 
				'attr' => [
					'placeholder' => $placeholder
				]
			];
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', TextType::class, $this->getConfiguration('Titre', "Tapez un super titre pour votre annonce !"))
			->add('slug', TextType::class, $this->getConfiguration('Chaine URL', "Tapez l'adresse Web (automatique)."))
			->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image principale", "Donnez l'adresse de l'image qui donne vraiment envie !"))
			->add('introduction', TextType::class, $this->getConfiguration('Introduction', "Donnez une description globale de l'annonce."))
			->add('contenu', TextareaType::class, $this->getConfiguration('Description détaillée', "Tapez une description qui donne vraiment envie de venir chez vous !"))
			->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit', "Indiquez le prix que vous voulez pour une nuit."))
			->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "Le nombre de chambres disponibles."))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ad::class,
		]);
	}
}
