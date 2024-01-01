<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Publication;
use App\Form\PublicationType;

#[Route("/publication")]
class PublicationController extends AbstractController
{   public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route("/", name: "publication_index", methods: ["GET"])]
    public function index(Request $request)
    {
        $publications = $this->entityManager->getRepository(Publication::class)->findAll();

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route("/new", name: "publication_new", methods: ["GET", "POST"])]
    public function new(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... Enregistrer la publication en base de données ...
            $entityManager = $this->entityManager->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}", name: "publication_show", methods: ["GET"])]
    public function show(Publication $publication)
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route("/{id}/edit", name: "publication_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Publication $publication)
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... Mettre à jour la publication en base de données ...
            $entityManager = $this->entityManager->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}/delete", name: "publication_delete", methods: ["GET"])]
    public function delete(Request $request, Publication $publication)
    {
        $entityManager = $this->entityManager->getManager();
        $entityManager->remove($publication);
        $entityManager->flush();

        $this->addFlash('success', 'La publication a été supprimée avec succès.');

        return $this->redirectToRoute('publication_index');
    }

    #[Route("/{id}/delete_confirm", name: "publication_delete_confirm", methods: ["GET"])]
    public function deleteConfirm(Request $request, Publication $publication)
    {
        return $this->render('publication/delete.html.twig', [
            'publication' => $publication,
        ]);
    }
}
