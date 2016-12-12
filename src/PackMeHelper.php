<?php

namespace Rukhsar\PackMe;

use RuntimeException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;

class PackMeHelper
{
    /**
     * The filesystem handler
     * @var [type]
     */
    protected $files;

    /**
     * Create a new instance of File System
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Setting custom formatting for the progress bar
     * @param  object $bar Symfony ProgressBar instance
     * @return object $bar Symfony ProgressBar instance
     */
    public function progressBarSetup(ProgressBar $bar)
    {
        $bar->setBarCharacter('<comment>=</comment>');

        $bar->setEmptyBarCharacter('-');

        $bar->setProgressCharacter('>');

        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% ');

        return $bar;
    }

    /**
     * Check if the package already exists
     * @param  string $path   Path to the package directory
     * @param  string $vendor The vendor
     * @param  string $name   Name of the package
     * @return void           Throws error if package exists, aborts process
     */
    public function checkExistingPackage($path, $vendor, $name)
    {
        if(is_dir($path.$vendor.'/'.$name))
        {
            throw new RuntimeException('Package already exist, choose a different name');
        }
    }

    /**
     * Create a directory if it doesn't exist
     * @param  string $path Path of the directory to make
     * @return void
     */
    public function makeDirectory($path)
    {
        if(!is_dir($path))
        {
            return mkdir($path);
        }
    }

    /**
     * Open haystack, find and replace needles, save haystack
     * @param  string $oldFile The haystack
     * @param  mixed  $search  String or array to look for (the needles)
     * @param  mixed  $replace What to replace the needles for?
     * @param  string $newFile Where to save, defaults to $oldFile
     * @param  boolean $deleteOldFile Whether to delete $oldFile or not
     * @return void
     */
    public function replaceAndSave($oldFile, $search, $replace, $newFile = null, $deleteOldFiles = false)
    {
        $newFile = ($newFile === null) ? $oldFile : $newFile ;

        $file = $this->files->get($oldFile);

        $replacing = str_replace($search, $replace, $file);

        $this->files->put($newFile, $replacing);

        if($deleteOldFiles)
            $this->files->delete($oldFile);
    }
}