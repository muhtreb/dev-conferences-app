<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EditionExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('editionDate', [$this, 'formatEditionDate']),
        ];
    }

    public function formatEditionDate(array $edition): string
    {
        $startDate = new \DateTime($edition['startDate']);
        $endDate = new \DateTime($edition['endDate']);

        if ($startDate->format('d-m-Y') === $endDate->format('d-m-Y')) {
            return $startDate->format('d F Y');
        }

        $startMonth = $startDate->format('F');
        $endMonth = $endDate->format('F');

        if ($startMonth === $endMonth) {
            return $startDate->format('d') . ' - ' . $endDate->format('d F Y');
        }

        $startYear = $startDate->format('Y');
        $endYear = $endDate->format('Y');

        if ($startYear === $endYear) {
            return $startDate->format('d F') . ' - ' . $endDate->format('d F Y');
        }

        return $startDate->format('j F Y') . ' - ' . $endDate->format('j F Y');
    }
}
