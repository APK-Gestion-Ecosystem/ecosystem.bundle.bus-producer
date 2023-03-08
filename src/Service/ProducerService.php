<?php

namespace Ecosystem\BusBundle\Service;

class ProducerService
{
    public function __construct(private array $buses)
    {
    }

    public function send(array $payload, $bus = 'default'): void
    {

    }
}
