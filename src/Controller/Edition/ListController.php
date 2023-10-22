<?php

namespace App\Controller\Edition;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route(
        path: '/editions',
        name: 'edition_list',
    )]
    public function __invoke(ApiClient $client, Request $request)
    {
        [
            'data' => $editions,
            'meta' => $meta
        ] = $client->getSearchEditionsResponse(
            query: $request->get('query'),
            limit: 30,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('edition/list.html.twig', [
            'editions' => $editions,
            'meta' => $meta,
        ]);
    }
}
