<?php

namespace Ecosystem\Event;

interface EventInterface
{
    public function getNamespace(): string;
    public function getEventName(): string;
    public function getData(): array;
}