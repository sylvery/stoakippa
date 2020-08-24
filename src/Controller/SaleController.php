<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\Transaction;
use App\Form\SaleType;
use App\Repository\SaleRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

/**
 * @Route("/sale")
 */
class SaleController extends AbstractController
{
    private $wf;
    public function __construct(Registry $registry)
    {
        $this->wf = $registry;
    }
    /**
     * @Route("/", name="sale_index", methods={"GET"})
     */
    public function index(SaleRepository $saleRepository): Response
    {
        return $this->render('sale/index.html.twig', [
            'sales' => $saleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sale_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sale->setDatetime(new DateTime('now', new DateTimeZone('Pacific/Port_Moresby')))
            ->setCashier($this->getUser());
            $trans = $sale->getTransactions();
            foreach ($trans as $transaction) {
                $transaction
                    ->setDatetime(new DateTime('now', new DateTimeZone('Pacific/Port_Moresby')))
                    ->setSale($sale)
                    ->setCost($transaction->getQuantity() * $transaction->getSaleitem()->getPrice());
                ;
                $item = $transaction->getSaleItem();
                $item->setQuantity($item->getQuantity() - $transaction->getQuantity());
                // var_dump($item->getQuantity()); exit;
                if ($item->getQuantity() < 10) {
                    $this->addFlash('danger', $item->getNameDesc() . ' stock will be depleted soon. You need to re-stock asap!');
                }
            }
            $swf = $this->wf->get($sale);
            if ($swf->can($sale, 'to_checkout')) {
                // var_dump($swf); exit; 
            }
            // $transactions = $form->getData()->getTransactions();
            // foreach ($transactions as $transaction) {
            //     $transOb = new Transaction();
            //     $transOb
            //         ->setDatetime()
            //         ->setItem($transaction->getItem())
            //         ->setQuantity($transaction->getQuantity())
            //         // ->setCost($transaction->getItem()->getCost())
            //         ->setSale($sale)
            //     ;
            //     $entityManager->persist($transOb);
            // }
            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->redirectToRoute('sale_show', ['id' => $sale->getId()]);
        }

        return $this->render('sale/new.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sale_show", methods={"GET"})
     */
    public function show(Sale $sale): Response
    {
        return $this->render('sale/show.html.twig', [
            'sale' => $sale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sale_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sale $sale): Response
    {
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sale_index');
        }

        return $this->render('sale/edit.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sale_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sale $sale): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sale_index');
    }
}
