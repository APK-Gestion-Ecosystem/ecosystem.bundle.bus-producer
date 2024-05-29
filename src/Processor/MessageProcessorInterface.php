<?php

namespace Ecosystem\BusProducerBundle\Processor;

use Ecosystem\BusProducerBundle\Message\MessageInterface;

interface MessageProcessorInterface
{
    public function processBusMessage(mixed $object, string $event): MessageInterface;
    public static function getMessageProcessorKey(): string;
}