<?php

namespace App\Security\Provider;

use App\Entity\User;
use App\Repository\UserRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthUserProvider implements OAuthAwareUserProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userRepository->findOneBy(['email' => $response->getEmail()]);

        if (null === $user) {
            $user = (new User())
                ->setEmail($response->getEmail());

            $this->userRepository->save($user);
        }

        return $user;
    }
}
