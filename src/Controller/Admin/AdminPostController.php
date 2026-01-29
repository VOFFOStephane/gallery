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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;


#[IsGranted('ROLE_ADMIN')]
final class AdminPostController extends AbstractController
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
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


        if ($form->isSubmitted() ) {
            $slug = strtolower($slugger->slug($painting->getTitle())->toString());
            $painting->setSlug($slug)
                ->setUser($this->getUser())
                ->setCreated(new \DateTimeImmutable())
            ->setEdited(new \DateTimeImmutable()); // 🔥 obligatoire

            $em->persist($painting);
            $em->flush();

            $this->addFlash('success', 'Post créé avec succès !');

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/posts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //Editer
    #[Route('/admin/editpost/{id}', name: 'admin_post_edit')]
    public function editPost(Request $request, EntityManagerInterface $em, Painting $painting): Response
    {
        $form = $this->createForm(PostType::class, $painting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $this->slugger->slug($painting->getTitle())->lower();
            $painting->setEdited(new \DateTimeImmutable())
            ->setSlug($slug);
            $em->flush();
            return $this->redirectToRoute('admin_post_index');
        }
        return $this->render('admin/posts/edit.html.twig', [
            'form' => $form,
            'painting' => $painting,
        ]);

    }
     //MASQUER
    #[Route('/admin/hidepost/{id}', name: 'app_admin_hidepost')]
    public function hidePost( Painting $painting, EntityManagerInterface $em): Response
    {
        $painting->setIsPublished(!$painting->IsPublished());
        $em->flush();
        return $this->redirectToRoute('admin_post_index');
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
