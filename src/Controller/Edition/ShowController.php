<?php

namespace App\Controller\Edition;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends AbstractController
{
    #[Route(
        path: '/edition/{slug}',
        name: 'edition_show'
    )]
    public function __invoke(ApiClient $client, string $slug, TranslatorInterface $translator): Response
    {
        try {
            $edition = $client->getEditionBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Edition '.$slug.' not found');
        }

        return $this->render('edition/show.html.twig', [
            'edition' => $edition,
            'breadcrumbItems' => [
                [
                    'name' => $translator->trans('breadcrumb.conferences'),
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
