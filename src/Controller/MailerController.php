<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class MailerController extends AbstractController
{
    #[Route('/', name: 'app_mailer')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    #[Route('/send-email', name: 'send_email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $mailer->send(
            (new Email())
                ->from('onboarding@resend.dev')
                ->to('delivered@resend.dev')
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
        );

        $this->addFlash('success', 'Email sent!');

        return $this->redirectToRoute('app_mailer');
    }
}
