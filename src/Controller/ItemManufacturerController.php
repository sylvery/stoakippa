<?php

namespace App\Controller;

use App\Entity\ItemManufacturer;
use App\Form\ItemManufacturerType;
use App\Repository\ItemManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manufacturer")
 */
class ItemManufacturerController extends AbstractController
{
    /**
     * @Route("/", name="item_manufacturer_index", methods={"GET"})
     */
    public function index(ItemManufacturerRepository $itemManufacturerRepository): Response
    {
        return $this->render('item_manufacturer/index.html.twig', [
            'item_manufacturers' => $itemManufacturerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="item_manufacturer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $itemManufacturer = new ItemManufacturer();
        $form = $this->createForm(ItemManufacturerType::class, $itemManufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($itemManufacturer);
            $entityManager->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item_manufacturer/new.html.twig', [
            'item_manufacturer' => $itemManufacturer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_manufacturer_show", methods={"GET"})
     */
    public function show(ItemManufacturer $itemManufacturer): Response
    {
        return $this->render('item_manufacturer/show.html.twig', [
            'item_manufacturer' => $itemManufacturer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_manufacturer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ItemManufacturer $itemManufacturer): Response
    {
        $form = $this->createForm(ItemManufacturerType::class, $itemManufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item_manufacturer/edit.html.twig', [
            'item_manufacturer' => $itemManufacturer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_manufacturer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ItemManufacturer $itemManufacturer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemManufacturer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($itemManufacturer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_manufacturer_index');
    }
}
