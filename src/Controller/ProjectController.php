<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;
use App\Form\ProjectType;

#[Route("/project")]
class ProjectController extends AbstractController
{   public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route("/", name: "project_index", methods: ["GET"])]
    public function index(Request $request)
    {
        $projects = $this->entityManager->getRepository(Project::class)->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    
    #[Route("/new", name: "project_new", methods: ["GET", "POST"])]
    public function new(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    
    #[Route("/{id}", name: "project_show", methods: ["GET"])]
    public function show(Project $project)
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route("/{id}/edit", name: "project_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/{id}/delete", name: "project_delete", methods: ["GET"])]
    public function delete(Request $request, Project $project)
    {
        $entityManager = $this->entityManager->getManager();
        $entityManager->remove($project);
        $entityManager->flush();

        $this->addFlash('success', 'Le projet a été supprimé avec succès.');

        return $this->redirectToRoute('project_index');
    }

    #[Route("/{id}/delete_confirm", name: "project_delete_confirm", methods: ["GET"])]
    public function deleteConfirm(Request $request, Project $project)
    {
        return $this->render('project/delete.html.twig', [
            'project' => $project,
        ]);
    }
}