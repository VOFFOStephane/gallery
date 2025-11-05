<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity; //pour mapper le slugger selon notre méthode


final class GalleryController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('Pages/Home.html.twig', [
            'controller_name' => 'GalleryController',
        ]);
    }

    ///routes gallery
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(PaintingRepository $paintingRepository): Response
    {

        $paintings = $paintingRepository->findBy(['is_published'=> true], ['created' => 'DESC']);
        return $this->render('Pages/Gallery.html.twig',[
            'paintings' => $paintings, // ✅ On envoie la variable au template
        ]);
    }

    #[Route('/gallery/{slug}', name: 'app_gallery_painting')]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Painting $painting
    ): Response
    {
        return $this->render('Pages/Painting.html.twig', [
            'painting' => $painting,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('Pages/About.html.twig');
    }

    #[Route('/team', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('Pages/Team.html.twig');
    }
}
