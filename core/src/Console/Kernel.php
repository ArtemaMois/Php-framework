<?php

namespace Timon\PhpFramework\Console;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use Timon\PhpFramework\Http\Request\Request;
use Timon\PhpFramework\Http\Response\Response;

class Kernel
{
    public function __construct(
        private ContainerInterface $container,
        private Application $application
    ) {}

    public function handle()
    {
        $this->registerCommands();
        $status = $this->application->run();

        return 0;
    }

    public function registerCommands()
    {
        $commandsNamespace = $this->getCommandsNamespace();
        $commands = new \DirectoryIterator(__DIR__.'/Command');
        foreach ($commands as $command) {
            if ($command->isFile()) {
                $commandClass = $commandsNamespace.pathinfo($command, PATHINFO_FILENAME);
                if (is_subclass_of($commandClass, CommandInterface::class)) {
                    $commandName = (new ReflectionClass($commandClass))->getProperty('name')->getDefaultValue();
                    $this->container->add("console:$commandName", $commandClass);
                }
            }
        }

    }

    private function getCommandsNamespace(): string
    {
        return $this->container->get('framework-commands-namespace');
    }

}
