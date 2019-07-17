<?php

namespace App\Controller;

use App\Entity\Attachments;
use App\Form\AttachmentsType;
use App\Repository\AttachmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attachments")
 */
class AttachmentsController extends AbstractController
{
    /**
     * @Route("/", name="attachments_index", methods={"GET"})
     */
    public function index(AttachmentsRepository $attachmentsRepository): Response
    {
        return $this->render('attachments/index.html.twig', [
            'attachments' => $attachmentsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attachments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attachment = new Attachments();
        $form = $this->createForm(AttachmentsType::class, $attachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attachment);
            $entityManager->flush();

            return $this->redirectToRoute('attachments_index');
        }

        return $this->render('attachments/new.html.twig', [
            'attachment' => $attachment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attachments_show", methods={"GET"})
     */
    public function show(Attachments $attachment): Response
    {
        return $this->render('attachments/show.html.twig', [
            'attachment' => $attachment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attachments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attachments $attachment): Response
    {
        $form = $this->createForm(AttachmentsType::class, $attachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attachments_index');
        }

        return $this->render('attachments/edit.html.twig', [
            'attachment' => $attachment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attachments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Attachments $attachment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attachment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attachment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attachments_index');
    }
}
