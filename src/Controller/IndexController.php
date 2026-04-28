<?php

namespace App\Controller;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'home')]
class IndexController extends AbstractController
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function __invoke(): Response
    {
        $topSpeakersResponse = $this->apiClient->getTopSpeakersResponse(limit: 12);

        return $this->render('index.html.twig', [
            'topSpeakers' => $topSpeakersResponse->toArray(),
        ]);
    }
}
