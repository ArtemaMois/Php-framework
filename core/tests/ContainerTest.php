<?php

namespace Timon\PhpFramework\Tests;

use PHPUnit\Framework\TestCase;
use Timon\PhpFramework\Container\Container;
use Timon\PhpFramework\Container\Exceptions\ServiceNotFoundException;

class ContainerTest extends TestCase
{
    public function test_getting_service_from_container()
    {
        $container = new Container;
        $container->add('test', SomeClass::class);
        $this->assertInstanceOf(SomeClass::class, $container->get('test'));
    }

    public function test_adding_wrong_id_to_container()
    {
        $container = new Container;
        $this->expectException(ServiceNotFoundException::class);
        $container->add('test');
    }

    public function test_has_true()
    {
        $container = new Container;
        $container->add('some', SomeClass::class);
        $this->assertTrue($container->has('some'));
    }

    public function test_has_false()
    {
        $container = new Container;
        $container->add('some', SomeClass::class);
        $this->assertFalse($container->has('tests'));
    }

    public function test_get_class()
    {
        $container = new Container;
        $container->add('some', SomeClass::class);
        /** @var SomeClass $some */
        $some = $container->get('some');
        $dep = $some->getDependency();
        $this->assertInstanceOf(DependencyClass::class, $some->getDependency());
        $this->assertInstanceOf(YouTube::class, $dep->getYoutube());
        $this->assertInstanceOf(Telegram::class, $dep->getTelegram());
    }
}
