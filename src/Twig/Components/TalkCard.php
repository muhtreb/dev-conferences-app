<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class TalkCard
{
    public array $talk;
    public string $url;
    public bool $showEdition = true;
    public bool $showSpeakers = true;
    public bool $showDate = false;

    public function getHasSpeakers(): bool
    {
        return isset($this->talk['speakers']) && count($this->talk['speakers']) > 0;
    }

    public function getDate(): string
    {
        return (new \DateTime($this->talk['date']))->format('j F Y');
    }

    // Get duration at format 01:30:03 (hours:minutes:seconds)
    // Do not display hours if duration is less than 1 hour
    public function getDuration(): string
    {
        $duration = $this->talk['duration'];
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = $duration - ($hours * 3600) - ($minutes * 60);

        $duration = '';
        if ($hours > 0) {
            $duration .= $hours . ':';
        }

        $duration .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
        $duration .= str_pad($seconds, 2, '0', STR_PAD_LEFT);

        return $duration;
    }
}
