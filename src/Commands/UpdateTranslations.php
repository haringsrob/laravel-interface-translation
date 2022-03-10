<?php

namespace Haringsrob\LaravelInterfaceTranslation\Commands;

use Haringsrob\LaravelInterfaceTranslation\Facades\LaravelInterfaceTranslation;
use Illuminate\Console\Command;

class UpdateTranslations extends Command
{
    protected $name = 'ui-translations:update';

    protected $description = 'Update the translations in the database by reparsing the project';

    public function handle(): void
    {
        LaravelInterfaceTranslation::parseAndUpdateDbWithStrings();
    }
}
