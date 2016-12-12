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
        // Progressbar Setup
        $bar= $this->helper->progressBarSetup($this->output->createProgressBar(7));

        // Start Progressbar
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

        // Start creating the package
        $this->info('Creating package '.$vendor.'\\'.$name.'...');

        // Check if the package already exist with this name and vendor
        if (!$this->option('force')) {
            $this->helper->checkExistingPackage($path, $vendor, $name);
        }

        // Move the progressbar to show progress
        $bar->advance();

        // Creating package directory
        $this->info('Creating package directory...');
        $this->helper->makeDirectory($path);

        // Move the progressbar to show progress
        $bar->advance();

        // Creating vendor directory
        $this->info('Creating vendor...');
        $this->helper->makeDirectory($path.$vendor);

        // Move the progressbar to show progress
        $bar->advance();

        // Copying the skeleton package
        $this->info('Creating skeleton package');
        File::copyDirectory(__DIR__.'/../skeletonPackage', $fullPath);

        foreach (File::allFiles($fullPath) as $file)
        {
            $search = [':vendor_name',':VendorName',':package_name',':PackageName'];

            $replace = [$vendor, $cVendor, $name, $cName];

            $newFile = substr($file, 0, -5);

            $this->helper->replaceAndSave($file, $search, $replace, $newFile, $deleteOldFiles = true);
        }

        // Move the progressbar to show progress
        $bar->advance();

        // Adding package to Composer.json
        $this->info('Adding package to composer and app...');

        $this->helper->replaceAndSave(getcwd() . '/composer.json', '"psr-4": {', $requirement);

        //And add it to the providers array in config/app.php
        $this->helper->replaceAndSave(getcwd() . '/config/app.php', 'App\Providers\RouteServiceProvider::class,',$appConfigLine);

        // Move the progressbar to show progress
        $bar->advance();

        // Finished creating the package, end of the progress bar
        $bar->finish();

        $this->info('Package created successfully!');

        $this->output->newLine(2);

        $bar = null;

    }
}
