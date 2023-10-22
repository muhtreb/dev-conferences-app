<?php

namespace App\Controller\Speaker;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route(
        path: '/speakers',
        name: 'speaker_list',
    )]
    public function __invoke(ApiClient $client, Request $request)
    {
        [
            'data' => $speakers,
            'meta' => $meta
        ] = $client->getSearchSpeakersResponse(
            query: $request->get('query'),
            limit: 30,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('speaker/list.html.twig', [
            'speakers' => $speakers,
            'meta' => $meta,
        ]);
    }
}
