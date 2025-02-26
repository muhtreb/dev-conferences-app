<?php

namespace App\Controller\Conference;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends AbstractController
{
    #[Route(
        path: '/conference/{slug}',
        name: 'conference_show',
        requirements: ['slug' => '[a-z0-9-]+']
    )]
    public function __invoke(ApiClient $client, string $slug, TranslatorInterface $translator): Response
    {
        try {
            $conference = $client->getConferenceBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Conference '.$slug.' not found');
        }

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'breadcrumbItems' => [
                [
                    'name' => $translator->trans('breadcrumb.conferences'),
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
