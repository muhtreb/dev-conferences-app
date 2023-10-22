<?php

namespace App\Controller\Conference;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route(
        path: '/conference/{slug}',
        name: 'conference_show',
        requirements: ['slug' => '[a-z0-9-]+']
    )]
    public function __invoke(ApiClient $client, string $slug)
    {
        try {
            $conference = $client->getConferenceBySlug($slug);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Conference ' . $slug . ' not found');
        }

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'breadcrumbItems' => [
                [
                    'name' => 'Accueil',
                    'url' => $this->generateUrl('home'),
                ],
                [
                    'name' => 'Conférences',
                    'url' => $this->generateUrl('conference_list'),
                ],
                [
                    'name' => $conference['name'],
                    'url' => null
                ],
            ],
        ]);
    }
}
