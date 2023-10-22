<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class SpeakerCard
{
    public array $speaker;
    public string $url;
}
