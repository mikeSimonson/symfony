<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Workflow\MarkingStore;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Workflow\Marking;

/**
 * PropertyAccessorMarkingStore.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class PropertyAccessorMarkingStore implements MarkingStoreInterface
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;


    /**
     * PropertyAccessorMarkingStore constructor.
     * @param string $property
     * @param PropertyAccessorInterface|null $propertyAccessor
     */
    public function __construct($property = 'marking', PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->property = $property;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param object $subject
     * @return Marking
     */
    public function getMarking($subject)
    {
        return new Marking($this->propertyAccessor->getValue($subject, $this->property) ?: []);
    }

    /**
     * @param object $subject
     * @param Marking $marking
     */
    public function setMarking($subject, Marking $marking)
    {
        $this->propertyAccessor->setValue($subject, $this->property, $marking->getPlaces());
    }
}
