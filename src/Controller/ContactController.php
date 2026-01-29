<?php

namespace App\Controller;

use App\DataClass\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(MailerInterface $mailer, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())->from($contact->getEmail())->to('info@webarticle.com')->subject($contact->getSubject())->text($contact->getMessage());
            $mailer->send($email);
            return $this->redirectToRoute('app_merci');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/merci', name: 'app_merci')]
    public function thankYou(): Response
    {
        return $this->render('Pages/remerciement.html.twig');
    }


}
