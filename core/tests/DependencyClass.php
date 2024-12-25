<?php

namespace Timon\PhpFramework\Tests;

class DependencyClass
{
    public function __construct(
        private readonly Telegram $telegram,
        private readonly YouTube $youtube
    ) {}

    public function getYoutube()
    {
        return $this->youtube;
    }

    public function getTelegram()
    {
        return $this->telegram;
    }
}
