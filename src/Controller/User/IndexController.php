<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function __invoke()
    {
        return $this->render('user/index.html.twig');
    }
}
