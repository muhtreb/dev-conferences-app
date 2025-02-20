<?php

namespace App\Controller;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]
class IndexController extends AbstractController
{
    public function __invoke(ApiClient $apiClient): Response
    {
        $topSpeakersResponse = $apiClient->getTopSpeakersResponse(limit: 12);

        return $this->render('index.html.twig', [
            'topSpeakers' => $topSpeakersResponse->toArray(),
        ]);
    }
}
