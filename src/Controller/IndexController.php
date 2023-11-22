<?php

namespace App\Controller;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/', name: 'home')]
class IndexController extends AbstractController
{
    public function __invoke(ApiClient $apiClient): Response
    {
        $editionsResponse = $apiClient->getLatestEditionsResponse(limit: 8);
        $topSpeakersResponse = $apiClient->getTopSpeakersResponse(limit: 12);

        return $this->render('index.html.twig', [
            'editions' => $editionsResponse->toArray(),
            'topSpeakers' => $topSpeakersResponse->toArray(),
        ]);
    }
}
