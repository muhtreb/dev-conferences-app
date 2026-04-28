<?php

namespace App\Controller\Speaker;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SpeakerController extends AbstractController
{
    public function __construct(private readonly ApiClient $client, private readonly TranslatorInterface $translator)
    {
    }

    #[Route(
        path: '/speaker/{slug}',
        name: 'speaker_show',
        requirements: ['slug' => '.*']
    )]
    public function __invoke(string $slug): Response
    {
        try {
            $speaker = $this->client->getSpeakerBySlug($slug);
        } catch (\Exception) {
            throw $this->createNotFoundException('Speaker '.$slug.' not found');
        }

        return $this->render('speaker/show.html.twig', [
            'speaker' => $speaker,
            'breadcrumbItems' => [
                [
                    'name' => $this->translator->trans('breadcrumb.speakers'),
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
