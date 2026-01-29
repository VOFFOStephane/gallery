<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PaintingRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity; //pour mapper le slugger selon notre méthode


final class GalleryController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PaintingRepository $repository): Response
    {
        $posts = $repository->findBy(['is_published'=> true], ['created' => 'DESC'], 3); //pour afficher par date de cration
        return $this->render('Pages/Home.html.twig', [
            'posts' => $posts,
        ]);
    }

    ///routes gallery
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(PaintingRepository $paintingRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $paintings = $paintingRepository->findBy(['is_published'=> true], ['created' => 'DESC']);
        $pagination = $paginator->paginate($paintings, $request->query->getInt('page', 1),
            10
        );
        return $this->render('Pages/Gallery.html.twig',[
            'paintings' => $pagination, // ✅ On envoie la variable au template
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


//affichage par categories
    #[Route('/gallery/category/{slug}', name: 'app_gallery_by_category')]
    public function galleryByCategory(
        #[MapEntity(mapping: ['slug' => 'slug'])] Category $category,
        PaintingRepository $repository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $repository->findByCategoryQuery($category);

        $paintings = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('Pages/Gallery.html.twig', [
            'paintings'  => $paintings,
            'category'   => $category,
            'categories' => $categoryRepository->findAll(),
        ]);
    }


}
