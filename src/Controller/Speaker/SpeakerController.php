<?php

namespace App\Controller\Speaker;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SpeakerController extends AbstractController
{
    #[Route(
        path: '/speaker/{slug}',
        name: 'speaker_show',
        requirements: ['slug' => '.*']
    )]
    public function __invoke(ApiClient $client, string $slug)
    {
        try {
            $speaker = $client->getSpeakerBySlug($slug);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Speaker ' . $slug . ' not found');
        }

        return $this->render('speaker/show.html.twig', [
            'speaker' => $speaker
        ]);
    }
}
