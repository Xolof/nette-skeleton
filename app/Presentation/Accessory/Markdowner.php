<?php

declare(strict_types=1);

namespace App\Presentation\Accessory;

use Parsedown;

class Markdowner
{
    protected Parsedown $parsedown;

    public function print(string $text): string
    {
        $this->parsedown = new Parsedown();
        $this->parsedown->setSafeMode(true);
        $this->parsedown->setUrlsLinked(true);
        return $this->parsedown->text($text);
    }
}
