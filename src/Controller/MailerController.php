<?php
// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
    ->from('fabien@example.com')
    ->to(new Address('ryan@example.com'))
    ->subject('Thanks for signing up!')

    // path of the Twig template to render
    ->htmlTemplate('emails/signup.html.twig')

    // pass variables (name => value) to the template
    ->context([
        'expiration_date' => new \DateTime('+7 days'),
        'username' => 'foo',
    ])
    ;
    $mailer->send($email);
    return new Response('Le message a été envoyé');
}
}