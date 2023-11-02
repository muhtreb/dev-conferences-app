<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginGithubCheckController extends AbstractController
{
    #[Route(path: '/login/check-github', name: 'security_login_github_check')]
    public function __invoke(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
