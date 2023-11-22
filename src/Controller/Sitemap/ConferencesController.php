<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConferencesController extends AbstractController
{
    #[Route('/sitemap/conferences', name: 'sitemap_conferences')]
    public function __invoke(ApiClient $apiClient)
    {
        $conferences = $apiClient->getConferences(limit: 1000);

        return $this->render('sitemap/conferences.xml.twig', [
            'conferences' => $conferences,
        ]);
    }
}