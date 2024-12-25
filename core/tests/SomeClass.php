<?php

namespace Timon\PhpFramework\Tests;

class SomeClass
{
    public function __construct(
        private readonly DependencyClass $dependency
    ) {}

    public function getDependency()
    {
        return $this->dependency;
    }
}
