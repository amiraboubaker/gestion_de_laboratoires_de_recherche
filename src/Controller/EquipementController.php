<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Equipement;
use App\Form\EquipementType;

#[Route("/equipement")]
class EquipementController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/", name: "equipement_index", methods: ["GET"])]
    public function index()
    {
        $equipements = $this->entityManager->getRepository(Equipement::class)->findAll();

        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    #[Route("/new", name: "equipement_new", methods: ["GET", "POST"])]
    public function new(Request $request)
    {
        dump(class_exists('App\Form\EquipementType'));
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($equipement); // Use directly
            $this->entityManager->flush();

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}", name: "equipement_show", methods: ["GET"])]
    public function show(Equipement $equipement)
    {
        return $this->render('equipement/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    #[Route("/{id}/edit", name: "equipement_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Equipement $equipement)
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush(); // Use directly

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}/delete", name: "equipement_delete", methods: ["GET"])]
    public function delete(Request $request, Equipement $equipement)
    {
        $this->entityManager->remove($equipement); // Use directly
        $this->entityManager->flush();

        $this->addFlash('success', 'L\'equipement a ete supprime avec succes.');

        return $this->redirectToRoute('equipement_index');
    }

    #[Route("/{id}/delete_confirm", name: "equipement_delete_confirm", methods: ["GET"])]
    public function deleteConfirm(Request $request, Equipement $equipement)
    {
        return $this->render('equipement/delete.html.twig', [
            'equipement' => $equipement,
        ]);
    }
}
