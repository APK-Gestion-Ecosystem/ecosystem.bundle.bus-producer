<?php

namespace Ecosystem\BusProducerBundle\Service;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class MessageDispatcherService
{
    public function __construct(
        #[TaggedIterator(tag: 'ecosystem.bus_producer.message_processor', defaultIndexMethod: 'getMessageProcessorKey')] private readonly iterable $processors,
        private ProducerService $producerService)
    {
    }

    public function dispatch(mixed $object, string $event): void
    {
        $processors = iterator_to_array($this->processors);

        if (!array_key_exists($object::class, $processors)) {
            throw new \Exception('No processor found for ' . $object::class);
        }

        $message = $processors[$object::class]->processBusMessage($object, $event);

        $this->producerService->publish(
            $message->toArray(),
        );
    }
}
