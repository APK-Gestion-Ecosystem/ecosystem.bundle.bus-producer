<?php

namespace Ecosystem\BusProducerBundle\Processor;

use Ecosystem\ProcessorBundle\Message\MessageInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

interface MessageProcessorInterface
{
    public function processBusMessage(mixed $object, string $event): MessageInterface;
    public static function getMessageProcessorKey(): string;
}