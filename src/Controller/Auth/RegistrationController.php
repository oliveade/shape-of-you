<?php

namespace App\Controller\Auth;

use App\Dto\RegisterDto;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $formLoginAuthenticator, MailerInterface $mailer): Response
    {
        $user = new User();
		
		$registerDto = new RegisterDto();
		
        $form = $this->createForm(RegistrationFormType::class, $registerDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			if ($registerDto->plainPassword !== $registerDto->confirmPassword) {
				$this->addFlash('error', 'Les mots de passe ne correspondent pas.');
				return $this->redirectToRoute('app_register');
			} else {
				$user->setEmail($registerDto->email);
				$user->setUsername($registerDto->username);
				$user->setBirthDate($registerDto->birthDate);
				$user->setPassword($userPasswordHasher->hashPassword($user, $registerDto->plainPassword));
				
				$entityManager->persist($user);
				$entityManager->flush();
			
				//handle register confirmation email
				$email = (new TemplatedEmail())
						->from('Acme <onboarding@resend.dev>')
						->to(new Address('delivered@resend.dev'))
						->subject('Thanks for signing up!')
						->htmlTemplate('emails/welcome.html.twig')
				;
				
				$mailer->send($email);
				
				$userAuthenticator->authenticateUser(
						$user,
						$formLoginAuthenticator,
						$request
				);
				
				return $this->redirectToRoute('app_profile');
			}
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form,
        ]);
    }

    //    #[Route('/verify/email', name: 'app_verify_email')]
    //    public function verifyUserEmail(Request $request): Response
    //    {
    //        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    //
    //        // validate email confirmation link, sets User::isVerified=true and persists
    //        try {
    //            /** @var User $user */
    //            $user = $this->getUser();
    //            $this->emailVerifier->handleEmailConfirmation($request, $user);
    //        } catch (VerifyEmailExceptionInterface $exception) {
    //            $this->addFlash('verify_email_error', $exception->getReason());
    //
    //            return $this->redirectToRoute('app_register');
    //        }
    //
    //        // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //        $this->addFlash('success', 'Your email address has been verified.');
    //
    //        return $this->redirectToRoute('app_register');
    //    }
}
