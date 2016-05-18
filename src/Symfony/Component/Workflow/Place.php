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

use Symfony\Component\Workflow\Exception\InvalidArgumentException;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class Place
{
    /**
     * @var string
     */
    private $name;

    /**
     * Place constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        if (!preg_match('{^[\w\d_-]+$}', $name)) {
            throw new InvalidArgumentException(sprintf('The place "%s" contains invalid characters.', $name));
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
