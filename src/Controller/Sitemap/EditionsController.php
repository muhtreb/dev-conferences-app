<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditionsController extends AbstractController
{
    #[Route('/sitemap/editions', name: 'sitemap_editions')]
    public function __invoke(ApiClient $apiClient)
    {
        $editions = $apiClient->getEditions(limit: 1000);

        return $this->render('sitemap/editions.xml.twig', [
            'editions' => $editions,
        ]);
    }
}
