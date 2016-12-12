<?php

namespace Rukhsar\PackMe;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PackMeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pack:me {vendor} {name} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $helper;

    public function __construct(PackMeHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bar= $this->helper->progressBarSetup($this->output->createProgressBar(7));

        $bar->start();

        // Command's common variables setup
        $vendor = strtolower($this->argument('vendor'));
        $name = strtolower($this->argument('name'));
        $path = getcwd().'/packages/';
        $fullPath = $path.$vendor.'/'.$name;

        $cVendor = studly_case($vendor);
        $cName = studly_case($name);

        $requirement = '"psr-4": {
            "' . $cVendor . '\\\\' . $cName . '\\\\": "packages/' . $vendor . '/' . $name . '/src",';

        $appConfigLine = 'App\Providers\RouteServiceProvider::class,
            ' . $cVendor . '\\' . $cName . '\\' . 'ServiceProvider::class,';

        echo $appConfigLine;

        $this->info('Creating package '.$vendor.'\\'.$name.'...');


    }
}
