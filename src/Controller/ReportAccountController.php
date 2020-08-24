<?php

namespace App\Controller;

use App\Repository\SaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportAccountController extends AbstractController
{
    /**
     * @Route("/report/account", name="report_account")
     */
    public function index(SaleRepository $sales)
    {
        return $this->render('report_account/index.html.twig', [
            'sales' => $sales->findAll(),
        ]);
    }
    /**
     * @Route("/api/sales", name="salesDataApi")
     */
    public function apiSalesData(SaleRepository $sales, Request $request): ?Response
    {
        $salesarray = [];
        foreach ($sales->findAll() as $sale) {
            foreach ($sale->getTransactions() as $transaction) {
                $cost = $transaction->getCost();
                if ($cost) {
                    array_push($salesarray,[
                        'id' => $transaction->getId(),
                        'cost' => $cost/100,
                        'date' => $transaction->getDatetime()->format('timestamp'),
                    ]);
                }
                // var_dump($transation->getCost());
            }
        }
        return new JsonResponse($salesarray);
    }
}
