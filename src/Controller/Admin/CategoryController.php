<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    //Cas unique comme pour le header qui est un partials
    //pas besoin de route
    public function Categories(CategoryRepository $repository): Response
    {
        $categories = $repository->findBy([], ['name' => 'ASC']);
        return $this->render('partials/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
