<?php 

namespace Timon\PhpFramework\Console\Command;

use Timon\PhpFramework\Console\CommandInterface;

class TestStartCommand implements CommandInterface
{

    private string $name = 'test';
    public function execute(array $params = []): int
    {
        echo "\e[33m" . exec('./core/vendor/bin/phpunit ./core/tests/' . $params['file'] . ' --colors') . PHP_EOL;
        return 1;
    }
}