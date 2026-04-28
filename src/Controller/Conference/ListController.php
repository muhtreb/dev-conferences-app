<?php

namespace App\Controller\Conference;

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
        path: '/conferences',
        name: 'conference_list',
    )]
    public function __invoke(Request $request): Response
    {
        $limit = 40;
        $page = $request->query->getInt('page', 1);

        ['data' => $conferences, 'meta' => $meta] = $this->client->getSearchConferencesResponse(
            query: $request->query->get('query'),
            limit: $limit,
            page: $page
        )->toArray();

        return $this->render('conference/list.html.twig', [
            'conferences' => $conferences,
            'meta' => $meta,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.conferences'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
