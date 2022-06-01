<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(): Response
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer)
    {   
        define('GMailUSER', 'yoharh56@gmail.com'); // utilisateur Gmail
        define('GMailPWD', 'Voiture56');
        $to = htmlspecialchars('zapkato56@gmail.com');
        $from = htmlspecialchars('yoharh56@gmail.com');
        $subject= htmlspecialchars("essai");
        $body = htmlspecialchars("joke");
        /*$email = (new Email())
            ->from('yoharh56@gmail.com')
            ->to('zapkato56@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Je t'envoi ce mail")
            ->text("C'est moi mm mandja")
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);*/

        // ...
        $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
        $mail->IsSMTP(); // active SMTP
        // $mail->SMTPDebug = 3;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
        $mail->SMTPAuth = true;  // Authentification SMTP active
        $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = GMailUSER;
        $mail->Password = GMailPWD;
        $mail->SetFrom($from);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        return $this->render("app_connexion");
    }
}
