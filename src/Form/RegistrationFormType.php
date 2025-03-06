<?php

namespace App\Form;

use App\Dto\RegisterDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
				->add('email', EmailType::class, [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
				])
				->add('username', TextType::class, [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
				])
				->add('birthDate', DateType::class, [
						'widget' => 'single_text',
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none'
						],
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700']
				])
				->add('plainPassword', PasswordType::class, [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none',
								'autocomplete' => 'new-password'
						],
						'label' => 'Mot de passe',
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
						'constraints' => [
								new NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
								new Length([
										'min' => 6,
										'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
								]),
						],
				])
				->add('confirmPassword', PasswordType::class, [
						'attr' => [
								'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none',
								'autocomplete' => 'new-password'
						],
						'label' => 'Confirmer le mot de passe',
						'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
						'constraints' => [
								new NotBlank(['message' => 'Veuillez confirmer votre mot de passe.']),
								new Length([
										'min' => 6,
										'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
								]),
						],
				]);
	}
	
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
				'data_class' => RegisterDto::class,
		]);
	}
}
