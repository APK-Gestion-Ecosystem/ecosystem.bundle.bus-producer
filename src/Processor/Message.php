<?php

namespace Ecosystem\BusProducerBundle\Message;

class Message implements MessageInterface
{
    public function __construct(
        private readonly string $namespace,
        private readonly string $event,
        private readonly array $data
    ) {}

    public function toArray(): array
    {
        return [
            'namespace' => $this->namespace,
            'event' => $this->event,
            'data' => $this->data,
        ];
    }
}
