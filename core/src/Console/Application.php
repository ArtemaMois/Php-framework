<?php

namespace Timon\PhpFramework\Console;

use Psr\Container\ContainerInterface;
use Timon\PhpFramework\Console\Exceptions\ConsoleException;

class Application
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function run(): int
    {
        $argv = $_SERVER['argv'];
        $commandId = $argv[1] ?? null;
        if (! $commandId) {
            throw new ConsoleException('Console command not found');
        }
        /**
         * @var CommandInterface @commandClass
         */
        $commandClass = $this->container->get("console:{$commandId}");
        $params = $this->getParams($argv);
        $commandClass->execute($params);

        return 0;
    }

    private function getParams($argv): array
    {
        if (count($argv) > 2) {
            return $this->parseParams(array_slice($argv, 2));
        }

        return [];
    }

    private function parseParams(array $args): array
    {
        $params = [];
        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                $arg = substr($arg, 2);
                $param = explode('=', $arg);
                if (count($param) > 1) {
                    $params[$param[0]] = $param[1];
                } else {
                    $params[$param[0]] = true;
                }
            }
        }

        return $params;
    }
}
