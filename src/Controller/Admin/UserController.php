<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['created_at' => 'DESC']);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
