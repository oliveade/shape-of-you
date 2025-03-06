<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSelfEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
				->add('email', null, [
					'attr' => ['class' => 'w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-rose-400']
			])
				->add('username', null, [
					'attr' => ['class' => 'w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-rose-400']
			])
				->add('birthdate', null, [
					'widget' => 'single_text',
					'attr' => ['class' => 'w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-rose-400']
			])
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
