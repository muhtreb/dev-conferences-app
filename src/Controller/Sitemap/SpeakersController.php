<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SpeakersController extends AbstractController
{
    #[Route('/sitemap/speakers', name: 'sitemap_speakers')]
    public function __invoke(ApiClient $apiClient)
    {
        $speakers = $apiClient->getSpeakers(limit: 1000);

        return $this->render('sitemap/speakers.xml.twig', [
            'speakers' => $speakers,
        ]);
    }
}
