<?php

namespace App\Controller\Talk;

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
        path: '/talk/{slug}',
        name: 'talk_show'
    )]
    public function __invoke(string $slug): Response
    {
        try {
            $talk = $this->client->getTalkBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Talk '.$slug.' not found');
        }

        $edition = $this->client->getEditionBySlug($talk['edition']['slug']);

        return $this->render('talk/show.html.twig', [
            'talk' => $talk,
            'edition' => $edition,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.conferences'),
                    'url' => $this->generateUrl('conference_list'),
                ],
                [
                    'name' => $talk['edition']['conference']['name'],
                    'url' => $this->generateUrl('conference_show', [
                        'slug' => $talk['edition']['conference']['slug'],
                    ]),
                ],
                [
                    'name' => $talk['edition']['name'],
                    'url' => $this->generateUrl('edition_show', [
                        'slug' => $talk['edition']['slug'],
                    ]),
                ],
                [
                    'name' => $talk['name'],
                    'url' => null,
                ],
            ],
        ]);
    }
}
