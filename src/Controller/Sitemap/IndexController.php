<?php

namespace App\Controller\Sitemap;

use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController extends AbstractController
{
    #[Route('/sitemap', name: 'sitemap')]
    public function __invoke()
    {
        return $this->render('sitemap/index.xml.twig', [
            'links' => [
                $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('conference_list', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('edition_list', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('talk_list', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('speaker_list', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('search', [], UrlGeneratorInterface::ABSOLUTE_URL),
                $this->generateUrl('about', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]
        ]);
    }
}