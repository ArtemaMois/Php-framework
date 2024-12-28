<?php

namespace Timon\PhpFramework\Console;

interface CommandInterface
{
    public function execute(array $params = []): int;
}
