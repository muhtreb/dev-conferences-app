<?php

namespace App\Twig\Extension;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EditionExtension extends AbstractExtension
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

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
            return $this->translator->trans('date.long', ['date' => $startDate]);
        }

        $startMonth = $startDate->format('F');
        $endMonth = $endDate->format('F');

        if ($startMonth === $endMonth) {
            return $startDate->format('d').' - '.$this->translator->trans('date.long', ['date' => $endDate]);
        }

        $startYear = $startDate->format('Y');
        $endYear = $endDate->format('Y');

        if ($startYear === $endYear) {
            $startDateFormatted = $this->translator->trans('date.long', ['date' => $startDate]);
            $startDateFormatted = str_replace($startYear, '', $startDateFormatted);
            $startDateFormatted = preg_replace('/[^A-Za-z0-9 ]/', '', $startDateFormatted);
            $startDateFormatted = trim($startDateFormatted);

            return $startDateFormatted.' - '.$this->translator->trans('date.long', ['date' => $endDate]);
        }

        return $this->translator->trans('date.long', ['date' => $startDate]).' - '.$this->translator->trans('date.long', ['date' => $endDate]);
    }
}
