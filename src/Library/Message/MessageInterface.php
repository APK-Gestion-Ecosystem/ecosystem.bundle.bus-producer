<?php 

namespace Ecosystem\BusProducerBundle\Library\Message;

interface MessageInterface
{
    /**
     * @return array<string, string|mixed>
     */
    public function toArray(): array;
}