<?php

namespace App\Controller\About;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route(path: '/about', name: 'about')]
    public function __invoke(Request $request): Response
    {
        $locale = $request->getLocale();
        $file = $this->getParameter('kernel.project_dir') . '/pages/about/about.' . $locale . '.MD';
        $markdown = file_get_contents($file);

        return $this->render('about/index.html.twig', [
            'markdown' => $markdown,
        ]);
    }
}