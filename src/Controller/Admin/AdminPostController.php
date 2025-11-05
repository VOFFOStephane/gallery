<?php

namespace App\Controller\Admin;

use App\Entity\Painting;
use App\Form\PostType;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


final class AdminPostController extends AbstractController
{
    #[Route('/admin/posts', name: 'admin_post_index')]
    public function index(PaintingRepository $paintingRepository): Response
    {
        $posts = $paintingRepository->findBy([], ['created' => 'DESC']);
        return $this->render('admin/posts/index.html.twig', [
            'posts' => $posts,

        ]);
    }


    #[Route('/admin/posts/new', name: 'admin_post_new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $painting = new Painting();
        $form = $this->createForm(PostType::class, $painting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($slugger->slug($painting->getTitle())->toString());
            $painting->setSlug($slug);
            $em->persist($painting);
            $em->flush();

            $this->addFlash('success', 'Post créé avec succès !');

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/posts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //SUPPRIMER
    #[\Symfony\Component\Routing\Annotation\Route('/admin/delpost/{id}', name: 'admin_delpost')]
    public function delPost(Painting $post, EntityManagerInterface $manager): Response
    {
        //paramconverter

        $manager->remove($post);
        $manager->flush();

        $this->addFlash('success', 'Article supprimé avec succès !');
        return $this->redirectToRoute('admin_post_index');
    }
}
