<?php

namespace App\Controller\Rss;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditionsController extends AbstractController
{
    #[Route('/rss/editions', name: 'rss_editions')]
    public function __invoke(ApiClient $apiClient)
    {
        $editions = $apiClient->getLatestEditions(limit: 30, withTalks: true);

        return $this->render('rss/editions.xml.twig', [
            'editions' => $editions,
        ]);
    }
}