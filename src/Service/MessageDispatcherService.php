<?php

namespace Ecosystem\BusProducerBundle\Service;

use Ecosystem\BusProducerBundle\Event\EventInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class MessageDispatcherService
{
    public function __construct(#[TaggedIterator('ecosystem.bus_producer.message_processor', defaultIndexMethod: 'getMessageProcessorKey')] private iterable $processors ,private ProducerService $producerService)
    {
    }

    public function dispatch(mixed $object, string $event): void
    {
        if (!isset($this->processors[$object::class])) {
            throw new \Exception(sprintf('Processor for object "%s" not found.', $object::class));
        }

        $message = $this->processors[$object::class]->processBusMessage($object, $event);

        if (!isset($message['namespace']) || !isset($message['event']) || !isset($message['data'])) {
            throw new \Exception('Invalid message format.');
        }

        $this->producerService->publish(
            $message,
        );
    }
}
