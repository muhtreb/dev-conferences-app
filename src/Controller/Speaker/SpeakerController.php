<?php

namespace App\Controller\Speaker;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;

class SpeakerController extends AbstractController
{
    #[Route(
        path: '/speaker/{slug}',
        name: 'speaker_show',
        requirements: ['slug' => '.*']
    )]
    public function __invoke(ApiClient $client, string $slug, TranslatorInterface $translator): Response
    {
        try {
            $speaker = $client->getSpeakerBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Speaker '.$slug.' not found');
        }

        return $this->render('speaker/show.html.twig', [
            'speaker' => $speaker,
            'breadcrumbItems' => [
                [
                    'name' => $translator->trans('breadcrumb.speakers'),
                    'url' => $this->generateUrl('speaker_list'),
                ],
                [
                    'name' => $speaker['firstName'].' '.$speaker['lastName'],
                    'url' => null,
                ],
            ],
        ]);
    }
}
