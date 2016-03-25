<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Workflow\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class AuditTrailListener implements EventSubscriberInterface
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLeave(Event $event)
    {
        foreach ($event->getTransition()->getFroms() as $place) {
            $this->logger->info(sprintf('leaving "%s" for subject of class "%s"', $place, get_class($event->getSubject())));
        }
    }

    public function onTransition(Event $event)
    {
        $this->logger->info(sprintf('transition "%s" for subject of class "%s"', $event->getTransition()->getName(), get_class($event->getSubject())));
    }

    public function onEnter(Event $event)
    {
        foreach ($event->getTransition()->getTos() as $place) {
            $this->logger->info(sprintf('entering "%s" for subject of class "%s"', $place, get_class($event->getSubject())));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'workflow.leave' => array('onLeave'),
            'workflow.transition' => array('onTransition'),
            'workflow.enter' => array('onEnter'),
        );
    }
}
