<?php

namespace Symfony\Component\Workflow\Tests\EventListener;

use Psr\Log\AbstractLogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\EventListener\AuditTrailListener;
use Symfony\Component\Workflow\MarkingStore\PropertyAccessorMarkingStore;
use Symfony\Component\Workflow\Place;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

class AuditTrailListenerTest extends \PHPUnit_Framework_TestCase
{

    public function testItWorks()
    {
        $places = Place::fromNames(['a', 'b']);

        $a = new Place('a');
        $b = new Place('b');
        $transitions = [
            new Transition('t1', $a, $b),
            new Transition('t2', $a, $b),
        ];

        $definition = new Definition($places, $transitions);

        $object = new \stdClass();
        $object->marking = null;

        $logger = new Logger();

        $ed = new EventDispatcher();
        $ed->addSubscriber(new AuditTrailListener($logger));

        $workflow = new Workflow($definition, new PropertyAccessorMarkingStore(), $ed);

        $workflow->apply($object, 't1');

        $expected = [
            'leaving "a" for subject of class "stdClass"',
            'transition "t1" for subject of class "stdClass"',
            'entering "b" for subject of class "stdClass"',
        ];

        $this->assertSame($expected, $logger->logs);
    }
}

class Logger extends AbstractLogger
{
    public $logs = [];

    public function log($level, $message, array $context = array())
    {
        $this->logs[] = $message;
    }
}
