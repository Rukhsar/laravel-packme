<?php

namespace Rukhsar\PackMe;

use RuntimeException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;

class PackMeHelper
{
    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function progressBarSetup(ProgressBar $bar)
    {
        $bar->setBarCharacter('<comment>=</comment>');

        $bar->setEmptyBarCharacter('-');

        $bar->setProgressCharacter('>');

        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% ');

        return $bar;
    }


}