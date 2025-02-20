<?php

namespace App\Twig\Components;

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
