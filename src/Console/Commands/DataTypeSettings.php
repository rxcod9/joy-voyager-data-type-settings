<?php

namespace Joy\VoyagerDataTypeSettings\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DataTypeSettings extends Command
{
    protected $name = 'joy-data-type-settings';

    protected $description = 'Joy Voyager DataTypeSettingser';

    public function handle()
    {
        $this->output->title('Starting data-type-settings');

        // Your magic here

        $this->output->success('DataTypeSettings successful');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['arguement1', InputArgument::REQUIRED, 'The argument1 description'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'option1',
                'o',
                InputOption::VALUE_OPTIONAL,
                'The option1 description',
                config('joy-voyager-data-type-settings.option1')
            ],
        ];
    }
}
