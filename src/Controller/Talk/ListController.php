<?php

namespace App\Controller\Talk;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractController
{
    #[Route(
        path: '/talks',
        name: 'talk_list',
    )]
    public function __invoke(ApiClient $client, Request $request, TranslatorInterface $translator): Response
    {
        [
            'data' => $talks,
            'meta' => $talksMeta,
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
                    'name' => $translator->trans('breadcrumb.talks'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
