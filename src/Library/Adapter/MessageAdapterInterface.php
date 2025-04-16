<?php

namespace Ecosystem\BusProducerBundle\Library\Adapter;

interface MessageAdapterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getData(): array;
}
