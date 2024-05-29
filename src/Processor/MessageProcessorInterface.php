<?php

namespace Ecosystem\ProcessorBundle\Processor;

use Ecosystem\BusProducerBundle\Event\EventInterface;

interface MessageProcessorInterface
{
    public function processBusMessage(mixed $object, string $event): array;
    public function getMessageProcessorKey(): string;
}