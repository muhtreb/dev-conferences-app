<?php

namespace App\Controller\LatestEditions;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PartialController extends AbstractController
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function __invoke(): Response
    {
        ['data' => $editions] = $this->apiClient->getLatestEditionsResponse(limit: 8)->toArray();

        return $this->render('latest_editions/_partial.html.twig', [
            'editions' => $editions,
        ]);
    }
}
