<?php

namespace App\Controller\Profile;

use App\Form\ProfileEdtType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile/view', name: 'app_profile')]
    public function index(): Response
    {
        //recuperer l'utilisateur via getUser
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', "Vous devez être connecté pour accéder à votre profil.");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/viewprofile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function editprofile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', "Vous devez être connecté pour modifier votre profil.");
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ProfileEdtType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Force l'update même si aucune image n'a été modifiée
            $user->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès !');
            return $this->redirectToRoute('app_profile_edit');
        }

        return $this->render('profile/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
