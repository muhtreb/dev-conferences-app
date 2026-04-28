<?php

namespace App\Controller\Rss;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditionsController extends AbstractController
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    #[Route('/rss/editions', name: 'rss_editions')]
    public function __invoke(): Response
    {
        $editions = $this->apiClient->getLatestEditions(limit: 30, withTalks: true);

        return $this->render('rss/editions.xml.twig', [
            'editions' => $editions,
        ]);
    }
}
