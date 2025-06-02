<?php

namespace App\Controller\Api\User\Favorite;

use App\Client\ApiClient;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/user/favorite', name: 'api_user_favorite', methods: ['POST'])]
#[IsGranted('ROLE_USER')]
class IndexController extends AbstractController
{
    public function __invoke(ApiClient $apiClient, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse($apiClient->getUserFavoriteData($user->getId(), $data));
    }
}
