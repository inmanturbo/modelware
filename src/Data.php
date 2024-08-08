<?php

namespace Inmanturbo\Modelware;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Data {
    public function __construct(
        public mixed $event,
        public ?object $model = null,
        public array $payload = [],
        public bool $halt = false,
    ) {}
}