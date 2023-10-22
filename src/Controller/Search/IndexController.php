<?php

namespace App\Controller\Search;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function __invoke(ApiClient $apiClient, Request $request): Response
    {
        $query = $request->query->get('query');

        $conferencesResponse = $apiClient->getSearchConferencesResponse(query: $query, limit: 20);
        $editionsResponse = $apiClient->getSearchEditionsResponse(query: $query, limit: 20);
        $talksResponse = $apiClient->getSearchTalksResponse(query: $query, limit: 12);
        $speakersResponse = $apiClient->getSearchSpeakersResponse(query: $query, limit: 20);

        ['data' => $conferences, 'meta' => $conferencesMeta] = $conferencesResponse->toArray();
        ['data' => $editions, 'meta' => $editionsMeta] = $editionsResponse->toArray();
        ['data' => $talks, 'meta' => $talksMeta] = $talksResponse->toArray();
        ['data' => $speakers, 'meta' => $speakersMeta] = $speakersResponse->toArray();

        return $this->render('search/index.html.twig', [
            'conferences' => $conferences,
            'conferencesMeta' => $conferencesMeta,
            'editions' => $editions,
            'editionsMeta' => $editionsMeta,
            'talks' => $talks,
            'talksMeta' => $talksMeta,
            'speakers' => $speakers,
            'speakersMeta' => $speakersMeta,
        ]);
    }
}
