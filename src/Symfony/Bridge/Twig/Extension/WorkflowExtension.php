<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Extension;

use Symfony\Component\Workflow\Registry;

/**
 * WorkflowExtension.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class WorkflowExtension extends \Twig_Extension
{
    private $workflowRegistry;

    public function __construct(Registry $workflowRegistry)
    {
        $this->workflowRegistry = $workflowRegistry;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('workflow_can', [$this, 'canTransition']),
            new \Twig_SimpleFunction('workflow_available_transitions', [$this, 'getAvailableTransitions']),
        );
    }

    public function canTransition($object, $transition, $name = null)
    {
        return $this->workflowRegistry->get($object, $name)->can($object, $transition);
    }

    public function getAvailableTransitions($object, $name = null)
    {
        return $this->workflowRegistry->get($object, $name)->getAvailableTransitions($object);
    }

    public function getName()
    {
        return 'workflow';
    }
}
