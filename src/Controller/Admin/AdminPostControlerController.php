<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminPostControlerController extends AbstractController
{
    #[Route('/admin/post/controler', name: 'app_admin_post_controler')]
    public function index(): Response
    {
        return $this->render('admin_post_controler/index.html.twig', [
            'controller_name' => 'AdminPostControlerController',
        ]);
    }
}
