<?php

namespace App\Controller;

use App\Entity\Tools;
use App\Form\ToolsType;
use App\Repository\ToolsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tools")
 */
class ToolsController extends AbstractController
{
    /**
     * @Route("/", name="tools_index", methods={"GET"})
     */
    public function index(ToolsRepository $toolsRepository): Response
    {
        return $this->render('tools/index.html.twig', [
            'tools' => $toolsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tools_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('tools_index');
        }

        return $this->render('tools/new.html.twig', [
            'tool' => $tool,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tools_show", methods={"GET"})
     */
    public function show(Tools $tool): Response
    {
        return $this->render('tools/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tools_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tools $tool): Response
    {
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tools_index');
        }

        return $this->render('tools/edit.html.twig', [
            'tool' => $tool,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tools_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tools $tool): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tool->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tools_index');
    }
}
