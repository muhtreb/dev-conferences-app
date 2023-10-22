<?php

namespace App\Controller\Conference;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route(
        path: '/conferences',
        name: 'conference_list',
    )]
    public function __invoke(ApiClient $client, Request $request)
    {
        $limit = 40;
        $page = $request->query->getInt('page', 1);

        [
            'data' => $conferences,
            'meta' => $meta
        ] = $client->getSearchConferencesResponse(
            limit: $limit,
            query: $request->get('query'),
            page: $page
        )->toArray();

        return $this->render('conference/list.html.twig', [
            'conferences' => $conferences,
            'meta' => $meta,
        ]);
    }
}
