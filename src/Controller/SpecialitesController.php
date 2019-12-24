<?php

namespace App\Controller;

use App\Entity\Specialites;
use App\Form\SpecialitesType;
use App\Repository\SpecialitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/specialites")
 */
class SpecialitesController extends AbstractController
{
    /**
     * @Route("/", name="specialites_index", methods={"GET"})
     */
    public function index(SpecialitesRepository $specialitesRepository): Response
    {
        return $this->render('specialites/index.html.twig', [
            'specialites' => $specialitesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="specialites_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $specialite = new Specialites();
        $form = $this->createForm(SpecialitesType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specialite);
            $entityManager->flush();

            return $this->redirectToRoute('specialites_index');
        }

        return $this->render('specialites/new.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialites_show", methods={"GET"})
     */
    public function show(Specialites $specialite): Response
    {
        return $this->render('specialites/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="specialites_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Specialites $specialite): Response
    {
        $form = $this->createForm(SpecialitesType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialites_index');
        }

        return $this->render('specialites/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialites_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Specialites $specialite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($specialite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialites_index');
    }
}