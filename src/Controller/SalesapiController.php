<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalesapiController extends AbstractController
{
    /**
     * @Route("/salesapi", name="salesapi")
     */
    public function index(Request $request, ItemRepository $itr): ?Response
    {
        $item = substr_replace($request->getQueryString(),'',0,5);
        $mItem = $itr->findOneBy(['itemCode'=>$item]);
        return new JsonResponse(['price'=>$mItem->getPrice()]);
    }
}
