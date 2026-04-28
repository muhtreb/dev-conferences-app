<?php

namespace App\Controller\Edition;

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
        path: '/editions',
        name: 'edition_list',
    )]
    public function __invoke(Request $request): Response
    {
        [
            'data' => $editions,
            'meta' => $meta,
        ] = $this->client->getSearchEditionsResponse(
            query: $request->query->get('query'),
            limit: 30,
            page: $request->query->getInt('page', 1)
        )->toArray();

        return $this->render('edition/list.html.twig', [
            'editions' => $editions,
            'meta' => $meta,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.editions'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
