<?php

namespace App\Twig\Components;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class TalkCardHorizontal
{
    public array $talk;
    public string $url;
    public bool $current = false;

    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function getHasSpeakers(): bool
    {
        return isset($this->talk['speakers']) && count($this->talk['speakers']) > 0;
    }

    public function getDate(): string
    {
        return $this->translator->trans('date.long', ['date' => new \DateTime($this->talk['date'])]);
    }

    public function getDuration(): string
    {
        $duration = $this->talk['duration'];
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = $duration - ($hours * 3600) - ($minutes * 60);

        $duration = '';
        if ($hours > 0) {
            $duration .= $hours.':';
        }

        $duration .= str_pad($minutes, 2, '0', STR_PAD_LEFT).':';
        $duration .= str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return $duration;
    }
}
