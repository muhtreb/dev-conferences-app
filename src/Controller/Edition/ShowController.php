<?php

namespace App\Controller\Edition;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ShowController extends AbstractController
{
    public function __construct(private readonly ApiClient $client, private readonly TranslatorInterface $translator)
    {
    }

    #[Route(
        path: '/edition/{slug}',
        name: 'edition_show'
    )]
    public function __invoke(string $slug): Response
    {
        try {
            $edition = $this->client->getEditionBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Edition '.$slug.' not found');
        }

        return $this->render('edition/show.html.twig', [
            'edition' => $edition,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.conferences'),
                    'url' => $this->generateUrl('conference_list'),
                ],
                [
                    'name' => $edition['conference']['name'],
                    'url' => $this->generateUrl('conference_show', [
                        'slug' => $edition['conference']['slug'],
                    ]),
                ],
                [
                    'name' => $edition['name'],
                    'url' => null,
                ],
            ],
        ]);
    }
}
