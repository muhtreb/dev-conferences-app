<?php

namespace App\Controller\Conference;

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
        path: '/conference/{slug}',
        name: 'conference_show',
        requirements: ['slug' => '[a-z0-9-]+']
    )]
    public function __invoke(string $slug): Response
    {
        try {
            $conference = $this->client->getConferenceBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Conference '.$slug.' not found');
        }

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.conferences'),
                    'url' => $this->generateUrl('conference_list'),
                ],
                [
                    'name' => $conference['name'],
                    'url' => null,
                ],
            ],
        ]);
    }
}
