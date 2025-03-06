<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
					'attr' => ['class' => 'w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-rose-400']
			])
			->add('password', null, [
					'attr' => ['class' => 'w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-rose-400']
			])
			->add('roles', ChoiceType::class, [
					'choices'  => [
							'Admin' => 'ROLE_ADMIN',
							'User' => 'ROLE_USER',
							'Banned' => 'ROLE_BANNED',
					],
					'expanded' => true,
					'multiple' => true,
					'choice_attr' => function ($choice, $key, $value) {
						return ['class' => 'h-5 w-5 accent-red-500 mr-2'];
					},
					'attr' => ['class' => 'grid grid-cols-[30px_3fr] gap-y-2'],
			]);
		
		$builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
			$form = $event->getForm();
			$data = $event->getData();
			
			if (!$data instanceof User) {
				return;
			}
			
			$roles = $data->getRoles();
			
			if (in_array('ROLE_BANNED', $roles)) {
				$data->setRoles(['ROLE_BANNED']);
			} elseif (in_array('ROLE_ADMIN', $roles)) {
				$data->setRoles(['ROLE_ADMIN']);
			} elseif (empty($roles)) {
				$data->setRoles(['ROLE_USER']);
			} else {
				$data->setRoles(['ROLE_USER']);
			}
		});
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
