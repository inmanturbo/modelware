<?php

namespace Inmanturbo\Modelware;

use Closure;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Pipeline;
use ReflectionFunction;

class Modelware
{
    public function add(string $event, array $pipes, string $prefix = 'modelware'): void
    {
        app()->bind("{$prefix}.{$event}", function () use ($pipes) {
            return collect($pipes)->map(fn ($pipe) => $this->isInvokableClass($pipe) ? app($pipe) : $pipe);
        });

        match (true) {
            str()->of($event)->contains('*') => Event::listen($event, function (string $events, array $payload) use ($event, $prefix) {
                return $this->eventPipeline($event, $payload, $events, $prefix);
            }),
            default => Event::listen($event, function (...$payload) use ($event, $prefix) {
                return $this->eventPipeline($event, $payload, $event, $prefix);
            }),
        };
    }

    protected static function eventPipeline(string $event, array $payload, $events, string $prefix)
    {
        $data = app(Data::class, [
            'event' => $events,
            'model' => $payload[0],
            'payload' => $payload,
        ]);

        return Pipeline::send($data)
            ->through(app("{$prefix}.{$event}")->toArray())
            ->then(fn ($data) => ! $data->halt);
    }

    protected function isInvokableClass($closure): bool
    {
        if ($closure instanceof Closure) {
            $reflection = new ReflectionFunction($closure);

            if ($reflection->isClosure()) {
                $object = $reflection->getClosureThis();

                return is_object($object) && method_exists($object, '__invoke');
            }

            return false;
        } elseif (is_string($closure) && class_exists($closure) && method_exists($closure, '__invoke')) {
            return true;
        }

        return false;
    }
}
