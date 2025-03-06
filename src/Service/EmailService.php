<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    public function __construct(private readonly MailerInterface $mailer, private string $adminEmail, private string $testEmail)
    {
    }

    public function sendEmaiTest(): void
    {
        $this->mailer->send(
            (new Email())
                ->from(shell_exec("Acme <$this->adminEmail>"))
                ->to($this->testEmail)
                ->subject('Hello world')
                ->html('<strong>it works!</strong>')
        );
    }

    public function sendEmailWelcome(
        string $to,
        string $template,
    ): void {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('')
            ->htmlTemplate(shell_exec("email/$template.html.twig"));

        $this->mailer->send($email);
    }

    public function sendEmailConfirmation(
        string $to,
        string $template,
    ): void {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('')
            ->htmlTemplate(shell_exec("email/$template.html.twig"));

        $this->mailer->send($email);
    }

    public function sendEmailResetPassword(
        string $to,
        string $template,
    ): void {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('')
            ->htmlTemplate(shell_exec("email/$template.html.twig"));

        $this->mailer->send($email);
    }

    public function sendEmailChangePassword(
        string $to,
        string $template,
    ): void {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('')
            ->htmlTemplate(shell_exec("email/$template.html.twig"));

        $this->mailer->send($email);
    }
}
