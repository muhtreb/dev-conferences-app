<?php

namespace App\Controller\Search;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IndexController extends AbstractController
{
    public function __construct(private readonly ApiClient $apiClient, private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/search', name: 'search')]
    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('query');

        $conferencesResponse = $this->apiClient->getSearchConferencesResponse(query: $query, limit: 20);
        $editionsResponse = $this->apiClient->getSearchEditionsResponse(query: $query, limit: 20);
        $talksResponse = $this->apiClient->getSearchTalksResponse(query: $query, limit: 12);
        $speakersResponse = $this->apiClient->getSearchSpeakersResponse(query: $query, limit: 20);

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
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.search'),
                    'url' => null,
                ],
            ],
        ]);
    }
}
