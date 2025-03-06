<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto
{
	#[Assert\NotBlank(message: 'Veuillez entrer votre adresse email.')]
	#[Assert\Email(message: 'Veuillez entrer une adresse email valide.')]
	public ?string $email = null;
	
	#[Assert\NotBlank(message: 'Veuillez entrer votre nom d\'utilisateur.')]
	public ?string $username = null;
	
	#[Assert\NotBlank(message: 'Veuillez entrer votre date de naissance.')]
	public ?\DateTimeInterface $birthDate = null;
	
	#[Assert\NotBlank(message: 'Veuillez entrer un mot de passe.')]
	public ?string $plainPassword = null;
	
	#[Assert\NotBlank(message: 'Veuillez confirmer votre mot de passe.')]
	public ?string $confirmPassword = null;
}
