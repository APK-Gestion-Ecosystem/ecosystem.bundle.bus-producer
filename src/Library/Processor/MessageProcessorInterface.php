<?php

namespace Ecosystem\BusProducerBundle\Library\Processor;

use Ecosystem\BusProducerBundle\Library\Message\MessageInterface;

interface MessageProcessorInterface
{
    public function processBusMessage(mixed $object, string $event): MessageInterface;
    public static function getMessageProcessorKey(): string;
}