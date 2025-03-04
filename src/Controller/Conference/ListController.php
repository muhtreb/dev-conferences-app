<?php

namespace App\Controller\Conference;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ListController extends AbstractController
{
    #[Route(
        path: '/conferences',
        name: 'conference_list',
    )]
    public function __invoke(ApiClient $client, Request $request, TranslatorInterface $translator): Response
    {
        $limit = 40;
        $page = $request->query->getInt('page', 1);

        ['data' => $conferences, 'meta' => $meta] = $client->getSearchConferencesResponse(
            query: $request->get('query'),
            limit: $limit,
            page: $page
        )->toArray();

        return $this->render('conference/list.html.twig', [
            'conferences' => $conferences,
            'meta' => $meta,
            'breadcrumbItems' => [
                [
                    'name' => $translator->trans('breadcrumb.conferences'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
