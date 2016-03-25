<?php

namespace Symfony\Component\Workflow\Tests;

use Symfony\Component\Workflow\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $transition = new Transition('name', 'a', 'b');

        $this->assertSame('name', $transition->getName());
        $this->assertSame(['a'], $transition->getFroms());
        $this->assertSame(['b'], $transition->getTos());
    }
}
