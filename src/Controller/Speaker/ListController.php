<?php

namespace App\Controller\Speaker;

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
        path: '/speakers',
        name: 'speaker_list',
    )]
    public function __invoke(Request $request): Response
    {
        [
            'data' => $speakers,
            'meta' => $meta,
        ] = $this->client->getSearchSpeakersResponse(
            query: $request->query->get('query'),
            limit: 30,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('speaker/list.html.twig', [
            'speakers' => $speakers,
            'meta' => $meta,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.speakers'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
