<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginLinkSentController extends AbstractController
{
    #[Route(path: '/login_link_sent', name: 'security_login_link_sent')]
    public function __invoke(Request $request): Response
    {
        $email = $request->getSession()->get('login_link_email');

        if (!$email) {
            return $this->redirectToRoute('security_login');
        }

        $request->getSession()->remove('login_link_email');

        return $this->render('security/login_link_sent.html.twig', [
            'email' => $email,
        ]);
    }
}
