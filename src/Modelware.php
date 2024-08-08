<?php

namespace Inmanturbo\Modelware;

use Illuminate\Support\Facades\Pipeline;

class Modelware {
    protected static function eventPipeline(string $event, array $payload, $events)
    {
        $data = (object) [
            'payload' => $payload,
            'event' => $events,
            'model' => $payload[0],
            'halt' => false,
        ];

        return Pipeline::send($data)
            ->through(app("ecow.{$event}")->toArray())
            ->then(fn ($data) => ! $data->halt);
    }
}
