<?php

namespace App\Twig\Components;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Like
{
    public string $type;
    public string $id;
    public string $name;
    public bool $active = false;
    public bool $focusable = true;
}
