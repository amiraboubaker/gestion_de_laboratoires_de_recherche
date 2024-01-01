<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Researcher;
use App\Form\ResearcherType;

#[Route("/researcher")]
class ResearcherController extends AbstractController
{   public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route("/", name: "researcher_index", methods: ["GET"])]
    public function index(Request $request)
    {  
        $researchers = $this->entityManager->getRepository(Researcher::class)->findAll();

        return $this->render('researcher/index.html.twig', [
            'researchers' => $researchers,
        ]);
    }

    #[Route("/new", name: "researcher_new", methods: ["GET", "POST"])]
    public function new(Request $request)
    {
        $researcher = new Researcher();
        $form = $this->createForm(ResearcherType::class, $researcher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... Enregistrer le chercheur en base de données avec gestion des mots de passe et de sécurité ...
            $entityManager = $this->entityManager->getManager();
            // ... Implémenter le hashage du mot de passe et les bonnes pratiques de sécurité ...
            $entityManager->persist($researcher);
            $entityManager->flush();

            return $this->redirectToRoute('researcher_index');
        }

        return $this->render('researcher/new.html.twig', [
            'researcher' => $researcher,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}", name: "equipement_show", methods: ["GET"])]
    public function show(Researcher $researcher)
    {
        return $this->render('researcher/show.html.twig', [
            'researcher' => $researcher,
        ]);
    }

    #[Route("/{id}/edit", name: "equipement_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Researcher $researcher)
    {
        $form = $this->createForm(ResearcherType::class, $researcher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... Enregistrer le chercheur mis à jour en base de données ...
            $entityManager = $this->entityManager->getManager();
            $entityManager->persist($researcher);
            $entityManager->flush();

            return $this->redirectToRoute('researcher_index');
        }

        return $this->render('researcher/edit.html.twig', [
            'researcher' => $researcher,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}/delete", name: "equipement_delete", methods: ["GET"])]
    public function delete(Request $request, Researcher $researcher)
    {
        $entityManager = $this->entityManager->getManager();
        $entityManager->remove($researcher);
        $entityManager->flush();

        $this->addFlash('success', 'Le chercheur a été supprimé avec succès.');

        return $this->redirectToRoute('researcher_index');
    }

    #[Route("/{id}/delete_confirm", name: "equipement_delete_confirm", methods: ["GET"])]
    public function deleteConfirm(Request $request, Researcher $researcher)
    {
        return $this->render('researcher/delete.html.twig', [
            'researcher' => $researcher,
        ]);
    }
}
