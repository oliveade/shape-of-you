<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
					'attr' => [
							'class' => 'w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-rose-300 focus:outline-none',
							'autocomplete' => 'new-password'
					],
					'label' => 'Mot de passe',
					'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
					'constraints' => [
							new NotBlank(['message' => 'Please enter a password',]),
							new Length(['min' => 6,
									'minMessage' => 'Your password should be at least {{ limit }} characters',
								// max length allowed by Symfony for security reasons
								//'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
