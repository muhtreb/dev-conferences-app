<?php

namespace App\Controller\Speaker;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractController
{
    #[Route(
        path: '/speakers',
        name: 'speaker_list',
    )]
    public function __invoke(ApiClient $client, Request $request, TranslatorInterface $translator): Response
    {
        [
            'data' => $speakers,
            'meta' => $meta,
        ] = $client->getSearchSpeakersResponse(
            query: $request->get('query'),
            limit: 30,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('speaker/list.html.twig', [
            'speakers' => $speakers,
            'meta' => $meta,
            'breadcrumbItems' => [
                [
                    'name' => $translator->trans('breadcrumb.speakers'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
