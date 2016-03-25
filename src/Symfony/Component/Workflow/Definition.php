<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Workflow;

use Symfony\Component\Workflow\Exception\LogicException;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class Definition
{
    private $places = array();
    private $transitions = array();
    private $initialPlace;

    public function getInitialPlace()
    {
        return $this->initialPlace;
    }

    public function getPlaces()
    {
        return $this->places;
    }

    public function getTransitions()
    {
        return $this->transitions;
    }

    public function setInitialPlace($name)
    {
        if (!isset($this->places[$name])) {
            throw new LogicException(sprintf('Place "%s" cannot be the initial place as it does not exist.', $name));
        }

        $this->initialPlace = $name;
    }

    public function addPlace($name)
    {
        if (!count($this->places)) {
            $this->initialPlace = $name;
        }

        $this->places[$name] = $name;
    }

    public function addPlaces(array $places)
    {
        foreach ($places as $place) {
            $this->addPlace($place);
        }
    }

    public function addTransition(Transition $transition)
    {
        $name = $transition->getName();

        foreach ($transition->getFroms() as $from) {
            if (!isset($this->places[$from])) {
                throw new LogicException(sprintf('Place "%s" referenced in transition "%s" does not exist.', $from, $name));
            }
        }

        foreach ($transition->getTos() as $to) {
            if (!isset($this->places[$to])) {
                throw new LogicException(sprintf('Place "%s" referenced in transition "%s" does not exist.', $to, $name));
            }
        }

        $this->transitions[$name] = $transition;
    }
}
