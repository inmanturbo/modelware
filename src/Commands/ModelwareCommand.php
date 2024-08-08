<?php

namespace Inmanturbo\Modelware\Commands;

use Illuminate\Console\Command;

class ModelwareCommand extends Command
{
    public $signature = 'modelware';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
