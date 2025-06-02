<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ConferencesController extends AbstractController
{
    #[Route('/sitemap/conferences', name: 'sitemap_conferences')]
    public function __invoke(ApiClient $apiClient): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($apiClient) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
            fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

            foreach ($this->generateUrls($apiClient) as $url) {
                fwrite($handle, $url);
            }

            fwrite($handle, '</urlset>');
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/xml');
        $response->headers->set('Cache-Control', 'max-age=86400, public');

        return $response;
    }

    private function generateUrls(ApiClient $apiClient): \Generator
    {
        $page = 1;
        do {
            ['data' => $conferences, 'meta' => $meta] = $apiClient->getConferences(limit: 100, page: $page);
            foreach ($conferences as $conference) {
                yield '<url>' . PHP_EOL;
                yield '<loc>' . htmlspecialchars($this->generateUrl('conference_show', ['slug' => $conference['slug']], UrlGeneratorInterface::ABSOLUTE_URL)) . '</loc>' . PHP_EOL;
                yield '<lastmod>' . (new \DateTime())->format('Y-m-d') . '</lastmod>' . PHP_EOL;
                yield '</url>' . PHP_EOL;
            }
            $page++;
        } while (null !== $meta['nextPage']);
    }
}