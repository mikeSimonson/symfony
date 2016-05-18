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

/**
 * Marking contains the place of every tokens.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class Marking
{
    /**
     * @var string[]
     */
    private $places = array();

    /**
     * @param string[] $representation keys are the place name and values should be 1
     */
    public function __construct(array $representation = array())
    {
        foreach ($representation as $placeName => $nbToken) {
            $this->markPlaceNamed($placeName);
        }
    }

    /**
     * @param Place $place place
     */
    public function mark(Place $place)
    {
        $this->places[$place->getName()] = 1;
    }

    /**
     * @param Place $place place
     */
    public function unmark(Place $place)
    {
        unset($this->places[$place->getName()]);
    }

    /**
     * @param string $placeName place name
     */
    public function markPlaceNamed($placeName)
    {
        $this->places[$placeName] = 1;
    }

    /**
     * @param string $placeName place name
     */
    public function unmarkPlaceNamed($placeName)
    {
        unset($this->places[$placeName]);
    }

    /**
     * @param Place $place
     *
     * @return bool
     */
    public function has(Place $place)
    {
        return isset($this->places[$place->getName()]);
    }

    /**
     * @param string $placeName place name
     *
     * @return bool
     */
    public function hasPlaceNamed($placeName)
    {
        return isset($this->places[$placeName]);
    }

    /**
     * @return Place[]
     */
    public function getPlaces()
    {
        return $this->places;
    }
}
