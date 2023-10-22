<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class SearchForm
{
    public ?string $placeholder = null;
    public ?string $action = null;
}
