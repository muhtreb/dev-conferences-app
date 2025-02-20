<?php

namespace App\Controller\Api\User\Favorite;

use App\Client\ApiClient;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/user/favorite/create', name: 'api_user_favorite_create', methods: ['POST'])]
#[IsGranted('ROLE_USER')]
class CreateController extends AbstractController
{
    public function __invoke(ApiClient $apiClient, Request $request): Response
    {
        ['type' => $type, 'id' => $id] = json_decode($request->getContent(), true);

        /** @var User $user */
        $user = $this->getUser();

        $apiClient->createUserFavorite($user->getId(), $type, $id);

        return new JsonResponse([]);
    }
}
