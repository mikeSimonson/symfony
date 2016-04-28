<?php

namespace Symfony\Component\Workflow\Tests;

use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Transition;

class DefinitionTest extends \PHPUnit_Framework_TestCase
{

    public function testAddPlaces()
    {
        $definition = new Definition();
        $definition->addPlaces(range('a', 'e'));

        $this->assertCount(5, $definition->getPlaces());

        $this->assertSame('a', $definition->getInitialPlace());
    }

    public function testSetInitialPlace()
    {
        $definition = new Definition();
        $definition->addPlaces(range('a', 'e'));

        $definition->setInitialPlace('d');

        $this->assertSame('d', $definition->getInitialPlace());
    }

    /**
     * @expectedException Symfony\Component\Workflow\Exception\LogicException
     * @expectedExceptionMessage Place "d" cannot be the initial place as it does not exist.
     */
    public function testsetInitialPlaceAndPlaceIsNotDefined()
    {
        $definition = new Definition();

        $definition->setInitialPlace('d');
    }

    public function testAddTransition()
    {
        $definition = new Definition();
        $definition->addPlaces(['a', 'b']);

        $definition->addTransition($transition = new Transition('name', 'a', 'b'));

        $this->assertCount(1, $definition->getTransitions());
        $this->assertSame($transition, $definition->getTransitions()['name']);
    }

    /**
     * @expectedException Symfony\Component\Workflow\Exception\LogicException
     * @expectedExceptionMessage Place "c" referenced in transition "name" does not exist.
     */
    public function testAddTransitionAndFromPlaceIsNotDefined()
    {
        $definition = new Definition();
        $definition->addPlaces(['a', 'b']);

        $definition->addTransition($transition = new Transition('name', 'c', 'b'));
    }

    /**
     * @expectedException Symfony\Component\Workflow\Exception\LogicException
     * @expectedExceptionMessage Place "c" referenced in transition "name" does not exist.
     */
    public function testAddTransitionAndToPlaceIsNotDefined()
    {
        $definition = new Definition();
        $definition->addPlaces(['a', 'b']);

        $definition->addTransition($transition = new Transition('name', 'a', 'c'));
    }
}
