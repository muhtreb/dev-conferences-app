<?php

namespace App\Controller\User\Favorite;

use App\Client\ApiClient;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/favorite', name: 'user_favorite_list')]
class IndexController extends AbstractController
{
    public function __invoke(ApiClient $apiClient): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $conferencesResponse = $apiClient->getUserFavoriteConferencesResponse($user->getId());
        $editionsResponse = $apiClient->getUserFavoriteEditionsResponse($user->getId());
        $speakersResponse = $apiClient->getUserFavoriteSpeakersResponse($user->getId());
        $talksResponse = $apiClient->getUserFavoriteTalksResponse($user->getId());

        return $this->render('user/favorite.html.twig', [
            'conferences' => $conferencesResponse->toArray(),
            'talks' => $talksResponse->toArray(),
            'editions' => $editionsResponse->toArray(),
            'speakers' => $speakersResponse->toArray(),
        ]);
    }
}
