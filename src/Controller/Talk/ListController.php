<?php

namespace App\Controller\Talk;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ListController extends AbstractController
{
    public function __construct(private readonly ApiClient $client, private readonly TranslatorInterface $translator)
    {
    }

    #[Route(
        path: '/talks',
        name: 'talk_list',
    )]
    public function __invoke(Request $request): Response
    {
        [
            'data' => $talks,
            'meta' => $talksMeta,
        ] = $this->client->getSearchTalksResponse(
            query: $request->query->get('query'),
            limit: 28,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('talk/list.html.twig', [
            'talks' => $talks,
            'meta' => $talksMeta,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.talks'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
