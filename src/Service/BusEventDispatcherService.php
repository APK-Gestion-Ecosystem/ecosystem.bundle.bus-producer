<?php

namespace Ecosystem\BusProducerBundle\Service;

use Ecosystem\Event\EventInterface;

class BusEventDispatcherService
{
    public function __construct(private ProducerService $producerService)
    {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->producerService->publish(
            [
                'namespace' => $event->getNamespace(),
                'event' => $event->getEventName(),
                'data' => $event->getData(),
            ],
            $event->getNamespace()
        );
    }
}
