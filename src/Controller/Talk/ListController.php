<?php

namespace App\Controller\Talk;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route(
        path: '/talks',
        name: 'talk_list',
    )]
    public function __invoke(ApiClient $client, Request $request)
    {
        [
            'data' => $talks,
            'meta' => $talksMeta
        ] = $client->getSearchTalksResponse(
            query: $request->get('query'),
            limit: 28,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('talk/list.html.twig', [
            'talks' => $talks,
            'meta' => $talksMeta,
            'breadcrumbItems' => [
                [
                    'name' => 'Accueil',
                    'url' => $this->generateUrl('home'),
                ],
                [
                    'name' => 'Vidéos',
                    'url' => null,
                ],
            ],
        ]);
    }
}
