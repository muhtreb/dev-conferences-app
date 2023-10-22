<?php

namespace App\Controller\Talk;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route(
        path: '/talk/{slug}',
        name: 'talk_show'
    )]
    public function __invoke(ApiClient $client, string $slug)
    {
        try {
            $talk = $client->getTalkBySlug($slug);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Talk ' . $slug . ' not found');
        }

        return $this->render('talk/show.html.twig', [
            'talk' => $talk
        ]);
    }
}
