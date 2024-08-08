<?php

namespace Inmanturbo\Modelware;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Pipeline;

class Modelware {

    public function add(string $event, array $pipes, string $prefix = 'modelware'): void
    {
        app()->bind("{$prefix}.{$event}", function () use ($pipes) {
            return collect($pipes)->map(fn ($pipe) => app($pipe));
        });

        Event::listen($event, function (string $events, array $payload) use ($event, $prefix) {
            return $this->eventPipeline($event, $payload, $events, $prefix);
        });
    }

    protected static function eventPipeline(string $event, array $payload, $events, string $prefix): bool
    {
        $data = app(Data::class, [
            'event' => $event,
            'model' => $payload[0],
            'payload' => $payload,
        ]);

        return Pipeline::send($data)
            ->through(app("{$prefix}.{$event}")->toArray())
            ->then(fn ($data) => ! $data->halt);
    }
}
