<?php

namespace Ecosystem\BusProducerBundle\Library\Message;

class Message implements MessageInterface
{

    public function __construct(
        private readonly string $namespace,
        private readonly string $event,
        private readonly array $data
    ) {}

    /**
     * @return array<string, string|mixed>
     */
    public function toArray(): array
    {
        return [
            'namespace' => $this->namespace,
            'event' => $this->event,
            'data' => $this->data,
        ];
    }
}
