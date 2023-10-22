<?php

namespace App\Controller\Edition;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route(
        path: '/edition/{slug}',
        name: 'edition_show'
    )]
    public function __invoke(ApiClient $client, string $slug)
    {
        try {
            $edition = $client->getEditionBySlug($slug);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Edition ' . $slug . ' not found');
        }

        return $this->render('edition/show.html.twig', [
            'edition' => $edition
        ]);
    }
}
