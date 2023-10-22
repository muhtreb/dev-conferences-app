<?php

namespace App\Twig\Components;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class MetaPagination
{
    public array $meta;

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getNextPageUrl(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $query = $request->query->all();
        $query['page'] = $this->meta['nextPage'];

        return $request->getPathInfo() . '?' . http_build_query($query);
    }

    public function getPrevPageUrl(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $query = $request->query->all();
        $query['page'] = $this->meta['prevPage'];

        if ($query['page'] === 1) {
            unset($query['page']);
        }

        if (empty($query)) {
            return $request->getPathInfo();
        }

        return $request->getPathInfo() . '?' . http_build_query($query);
    }
}
