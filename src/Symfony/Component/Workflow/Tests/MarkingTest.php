<?php

namespace Symfony\Component\Workflow\Tests;

use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\Place;

class MarkingTest extends \PHPUnit_Framework_TestCase
{
    public function testWithNaming()
    {
        $marking = new Marking(['a' => 1]);

        $this->assertTrue($marking->hasPlaceNamed('a'));
        $this->assertFalse($marking->hasPlaceNamed('b'));
        $this->assertSame(['a' => 1], $marking->getPlaces());

        $marking->markPlaceNamed('b');

        $this->assertTrue($marking->hasPlaceNamed('a'));
        $this->assertTrue($marking->hasPlaceNamed('b'));
        $this->assertSame(['a' => 1, 'b' => 1], $marking->getPlaces());

        $marking->unmarkPlaceNamed('a');

        $this->assertFalse($marking->hasPlaceNamed('a'));
        $this->assertTrue($marking->hasPlaceNamed('b'));
        $this->assertSame(['b' => 1], $marking->getPlaces());

        $marking->unmarkPlaceNamed('b');

        $this->assertFalse($marking->hasPlaceNamed('a'));
        $this->assertFalse($marking->hasPlaceNamed('b'));
        $this->assertSame([], $marking->getPlaces());
    }

    public function testWithObject()
    {
        $a = new Place('a');
        $b = new Place('b');

        $marking = new Marking(['a' => 1]);

        $this->assertTrue($marking->has($a));
        $this->assertFalse($marking->has($b));
        $this->assertSame(['a' => 1], $marking->getPlaces());

        $marking->mark($b);

        $this->assertTrue($marking->has($a));
        $this->assertTrue($marking->has($b));
        $this->assertSame(['a' => 1, 'b' => 1], $marking->getPlaces());

        $marking->unmark($a);

        $this->assertFalse($marking->has($a));
        $this->assertTrue($marking->has($b));
        $this->assertSame(['b' => 1], $marking->getPlaces());

        $marking->unmark($b);

        $this->assertFalse($marking->has($a));
        $this->assertFalse($marking->has($b));
        $this->assertSame([], $marking->getPlaces());
    }
}
