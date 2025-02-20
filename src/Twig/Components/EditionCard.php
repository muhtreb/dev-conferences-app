<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class EditionCard
{
    public array $edition;
    public ?string $url = null;
    public bool $showThumbnail = false;
}
