<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Button
{
    public string $tag = 'button';
    public ?string $href = null;
    public string $target = '_self';
}
