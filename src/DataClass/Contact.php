<?php
namespace App\DataClass;

use Symfony\Component\Validator\Constraints as Assert;
class Contact
{
    //ceci est une entité non migrable que j'ai creer dans un dossier class que j'ai creer moi meme
    //ceci est fait pour le formulaire de contact car je ne vais pas stocker ses info dans ma bd


    #[Assert\NotBlank]
    private string $name;
    #[Assert\NotBlank]
    private string $lastname;
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Votre Email {{ value }} n\'est pas valide.',
    )]
    private string $email;
    #[Assert\NotBlank]
    private string $subject;
    #[Assert\NotBlank]
    private string $message;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): \App\DataClass\Contact
    {
        $this->name = $name;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Contact
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Contact
    {
        $this->message = $message;
        return $this;
    }
}
