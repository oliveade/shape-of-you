<?php

namespace App\Form;

use App\Dto\PasswordUpdateDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
				->add('oldPassword', PasswordType::class , [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label' => 'Ancien mot de passe',
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
				])
				->add('newPassword', PasswordType::class , [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label' => 'Nouveau mot de passe',
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
				])
				->add('confirmPassword', PasswordType::class , [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label' => 'Confirmation de mot de passe',
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
				])
		;
    }
	
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
				'data_class' => PasswordUpdateDto::class, // Associer le DTO au formulaire
		]);
	}
}
