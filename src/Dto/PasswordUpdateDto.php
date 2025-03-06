<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdateDto
{
	#[Assert\NotBlank(message: 'Veuillez entrer votre ancien mot de passe.')]
	public ?string $oldPassword = null;
	
	#[Assert\NotBlank(message: 'Veuillez entrer votre nouveau mot de passe.')]
	public ?string $newPassword = null;
	
	#[Assert\NotBlank(message: 'Veuillez confirmer votre nouveau mot de passe.')]
	public ?string $confirmPassword = null;
}
