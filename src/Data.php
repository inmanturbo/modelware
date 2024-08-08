<?php

namespace Inmanturbo\Modelware;

class Data
{
    public function __construct(
        public mixed $event,
        public ?object $model = null,
        public array $payload = [],
        public bool $halt = false,
    ) {}
}
