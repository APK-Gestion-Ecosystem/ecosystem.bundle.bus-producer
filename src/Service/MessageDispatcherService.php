<?php

namespace Ecosystem\BusProducerBundle\Service;

use Ecosystem\BusProducerBundle\Event\EventInterface;
use Ecosystem\BusProducerBundle\Processor\MessageProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

#[AsTaggedItem('ecosystem.bus_producer.message_dispatcher')]
class MessageDispatcherService
{
    public function __construct(
        #[TaggedIterator(tag: 'ecosystem.bus_producer.message_processor', defaultIndexMethod: 'getMessageProcessorKey')] private readonly iterable $processors,
        private ProducerService $producerService)
    {
    }

    public function addProcessor(MessageProcessorInterface $processor): void
    {
        $this->processors[$processor->getMessageProcessorKey()] = $processor;
    }

    public function dispatch(mixed $object, string $event): void
    {
        $processors = iterator_to_array($this->processors);
        dump($processors);
        die;
        if (!array_key_exists($object::class, $processors)) {
            throw new \Exception('No processor found for ' . $object::class);
        }

        $message = $processors[$object::class]->processBusMessage($object, $event);

        $this->producerService->publish(
            $message->toArray(),
        );
    }
}
