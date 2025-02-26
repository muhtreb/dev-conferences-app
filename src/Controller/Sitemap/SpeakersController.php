<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SpeakersController extends AbstractController
{
    #[Route('/sitemap/speakers', name: 'sitemap_speakers')]
    public function __invoke(ApiClient $apiClient): Response
    {
        $speakers = $apiClient->getSpeakers(limit: 1000);

        return $this->render('sitemap/speakers.xml.twig', [
            'speakers' => $speakers,
        ]);
    }
}
