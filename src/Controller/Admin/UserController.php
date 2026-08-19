<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'app_user')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
