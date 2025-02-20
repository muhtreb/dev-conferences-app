<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient
{
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        private string $baseUrl,
        private string $apiAdminToken,
    ) {
        $this->client = $client->withOptions([
            'base_uri' => $this->baseUrl,
            'verify_peer' => false,
        ]);
    }

    public function request(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $endpoint, $options);
    }

    public function getConferences(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/conferences',
            [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]
        )->toArray();
    }

    public function getConferenceBySlug(string $slug): array
    {
        return $this->client->request('GET', '/conferences/slug/'.$slug)->toArray();
    }

    public function getSearchConferencesResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page,
            ],
        ]);
    }

    public function getLatestEditions(int $limit = 12, bool $withTalks = false): array
    {
        return $this->getLatestEditionsResponse($limit, $withTalks)->toArray();
    }

    public function getLatestEditionsResponse(int $limit = 12, bool $withTalks = false): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/editions/latest', [
            'query' => [
                'limit' => $limit,
                'withTalks' => $withTalks,
            ],
        ]);
    }

    public function getEditions(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/conferences/editions', [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ])->toArray();
    }

    public function getSearchEditionsResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/conferences/editions/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page,
            ],
        ]);
    }

    public function getConferenceEditions(string $id): array
    {
        return $this->client->request('GET', '/conferences/'.$id.'/editions')->toArray();
    }

    public function getEditionBySlug(string $slug): array
    {
        return $this->client->request('GET', '/conferences/editions/slug/'.$slug)->toArray();
    }

    public function getSearchTalksResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/talks/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page,
            ],
        ]);
    }

    public function getTalkBySlug(string $slug): array
    {
        return $this->client->request('GET', '/talks/slug/'.$slug)->toArray();
    }

    public function getSearchSpeakersResponse(?string $query = null, int $limit = 10, int $page = 1): ResponseInterface
    {
        return $this->client->request('GET', '/speakers/search', [
            'query' => [
                'query' => $query,
                'limit' => $limit,
                'page' => $page,
            ],
        ]);
    }

    public function getTopSpeakers(int $limit = 10): array
    {
        return $this->getTopSpeakersResponse($limit)->toArray();
    }

    public function getTopSpeakersResponse(int $limit = 10): ResponseInterface
    {
        return $this->client->request('GET', '/speakers/top', [
            'query' => [
                'limit' => $limit,
            ],
        ]);
    }

    public function getSpeakerBySlug(string $slug): array
    {
        return $this->client->request('GET', '/speakers/slug/'.$slug)->toArray();
    }

    public function getSpeakers(int $limit = 10, int $offset = 0): array
    {
        return $this->client->request('GET', '/speakers', [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ],
        ])->toArray();
    }

    private function sendUserFavoriteRequest(string $method, string $endpoint, string $userId, ?string $resourceId = null): ResponseInterface
    {
        $url = '/admin/user/'.$userId.'/favorite/'.$endpoint;
        if (null !== $resourceId) {
            $url .= '/'.$resourceId;
        }

        return $this->client->request(
            $method,
            $url,
            [
                'headers' => [
                    'x-auth-token' => $this->apiAdminToken,
                ],
            ]
        );
    }

    public function getUserFavoriteConferencesResponse(string $userId): ResponseInterface
    {
        return $this->sendUserFavoriteRequest('GET', 'conferences', $userId);
    }

    public function addUserFavoriteConference(string $userId, string $conferenceId): void
    {
        $this->sendUserFavoriteRequest('POST', 'conferences', $userId, $conferenceId);
    }

    public function getUserFavoriteTalksResponse(string $userId): ResponseInterface
    {
        return $this->sendUserFavoriteRequest('GET', 'talks', $userId);
    }

    public function addUserFavoriteTalk(string $userId, string $talkId): void
    {
        $this->sendUserFavoriteRequest('POST', 'talks', $userId, $talkId);
    }

    public function getUserFavoriteSpeakersResponse(string $userId): ResponseInterface
    {
        return $this->sendUserFavoriteRequest('GET', 'speakers', $userId);
    }

    public function addUserFavoriteSpeaker(string $userId, string $speakerId): void
    {
        $this->sendUserFavoriteRequest('POST', 'speakers', $userId, $speakerId);
    }

    public function getUserFavoriteEditionsResponse(string $userId): ResponseInterface
    {
        return $this->sendUserFavoriteRequest('GET', 'conference_editions', $userId);
    }

    public function addUserFavoriteEdition(string $userId, string $editionId): void
    {
        $this->sendUserFavoriteRequest('POST', 'conference_editions', $userId, $editionId);
    }

    public function getUserFavoriteData(string $userId, array $data): array
    {
        return $this->client->request('POST', '/admin/user/'.$userId.'/favorite/data', [
            'headers' => [
                'x-auth-token' => $this->apiAdminToken,
            ],
            'json' => $data,
        ])->toArray();
    }

    private function sendFavoriteRequest(string $userId, string $type, string $id, string $action): void
    {
        $endpoint = match ($type) {
            'conference' => 'conferences',
            'talk' => 'talks',
            'speaker' => 'speakers',
            'conferenceEdition' => 'conference_editions',
            default => throw new \InvalidArgumentException('Invalid type'),
        };

        $this->client->request('POST', '/admin/user/'.$userId.'/favorite/'.$endpoint.'/'.$id.'/'.$action, [
            'headers' => [
                'x-auth-token' => $this->apiAdminToken,
            ],
        ]);
    }

    public function createUserFavorite(string $userId, string $type, string $id): void
    {
        $this->sendFavoriteRequest($userId, $type, $id, 'create');
    }

    public function deleteUserFavorite(string $userId, string $type, string $id): void
    {
        $this->sendFavoriteRequest($userId, $type, $id, 'delete');
    }
}
