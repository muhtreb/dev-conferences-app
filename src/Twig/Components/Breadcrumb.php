<?php

namespace App\Twig\Components;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Breadcrumb
{
    public array $items = [];

    public function __construct(
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    public function getBreadcrumbItems(): array
    {
        return [
            [
                'name' => $this->translator->trans('breadcrumb.home'),
                'url' => $this->urlGenerator->generate('home')
            ],
            ...$this->items
        ];
    }
}
