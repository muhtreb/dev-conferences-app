<?php

namespace App\Controller\User\Favorite;

use App\Client\ApiClient;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/favorite', name: 'user_favorite_list')]
class IndexController extends AbstractController
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function __invoke(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $conferencesResponse = $this->apiClient->getUserFavoriteConferencesResponse($user->getId());
        $editionsResponse = $this->apiClient->getUserFavoriteEditionsResponse($user->getId());
        $speakersResponse = $this->apiClient->getUserFavoriteSpeakersResponse($user->getId());
        $talksResponse = $this->apiClient->getUserFavoriteTalksResponse($user->getId());

        return $this->render('user/favorite.html.twig', [
            'conferences' => $conferencesResponse->toArray(),
            'talks' => $talksResponse->toArray(),
            'editions' => $editionsResponse->toArray(),
            'speakers' => $speakersResponse->toArray(),
        ]);
    }
}
