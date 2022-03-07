<?php

interface EmailSenderInterface {
    public function send(string $recipient, string $message): void;
}

class AmazonEmailSender implements EmailSenderInterface
{
    public function send(string $recipient, string $message): void
    {
        // Uses Amazon SES to send email...
    }
}

class SendgridEmailSender implements EmailSenderInterface
{
    public function send(string $recipient, string $message): void
    {
        // Sends email via Sendgrid...
    }
}

class RegistrationManager
{
    private EmailSenderInterface $emailSender;

    public function __construct(EmailSenderInterface $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    public function registerUser(array $data): void
    {
        // ...

        $this->sendWelcomeEmail($data['email']);
    }

    private function sendWelcomeEmail(string $email): void
    {
        $message = 'Welcome!';
        $this->emailSender->send($email, $message);
    }
}
