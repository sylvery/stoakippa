<?php

namespace App\Controller;

use App\Entity\ItemCategory;
use App\Form\ItemCategoryType;
use App\Repository\ItemCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/item/category")
 */
class ItemCategoryController extends AbstractController
{
    /**
     * @Route("/", name="item_category_index", methods={"GET"})
     */
    public function index(ItemCategoryRepository $itemCategoryRepository): Response
    {
        return $this->render('item_category/index.html.twig', [
            'item_categories' => $itemCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="item_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $itemCategory = new ItemCategory();
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($itemCategory);
            $entityManager->flush();

            $this->addFlash('success','Item category added successfully');
            return $this->redirectToRoute('item_category_new');
        }

        return $this->render('item_category/new.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_category_show", methods={"GET"})
     */
    public function show(ItemCategory $itemCategory): Response
    {
        return $this->render('item_category/show.html.twig', [
            'item_category' => $itemCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ItemCategory $itemCategory): Response
    {
        $form = $this->createForm(ItemCategoryType::class, $itemCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_category_index', [
                'id' => $itemCategory->getId(),
            ]);
        }

        return $this->render('item_category/edit.html.twig', [
            'item_category' => $itemCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ItemCategory $itemCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($itemCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_category_index');
    }
}
