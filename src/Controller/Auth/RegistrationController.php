<?php

namespace App\Controller\Auth;

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
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

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

            return $this->redirectToRoute('app_mailer');
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
