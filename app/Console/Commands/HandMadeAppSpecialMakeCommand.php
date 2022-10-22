<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class HandMadeAppSpecialMakeCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'make:hand-made-command';

    /**
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userInputClassName = $this->ask('What is the name of the class');
        if($userInputClassName === NULL) {
            throw new InvalidArgumentException("Invalid class name. You have to enter any name");
        }
        $modelClassName = "Models/".$userInputClassName;
        $repositoryClassName = $userInputClassName."Repository";
        $serviceClassName = $userInputClassName."Service";
        $controllerClassName = $userInputClassName."Controller";
        $userInputDirectoryName = $this->ask(
            "Do you want to make any directory for service class?\n If yes, Then enter the directory name otherwise press Enter key"
        );
        if($userInputDirectoryName !== NULL) {
            $serviceClassName = $userInputDirectoryName."/".$serviceClassName;
            $controllerClassName = $userInputDirectoryName."/".$controllerClassName;
        }
        $forApiControllerClassName = "Api/". $controllerClassName ;
        $forWebControllerClassName = "Web/". $controllerClassName ;
        $userChoice = $this->choice(
            'What do you want to publish against this class',
            [
                'All',
                'Model Migration Seeder',
                'Model Migration Seeder Repository',
                'Model Migration Seeder Repository Service',
                'Controller Service',
            ]
        );
        if ($userChoice === 'All') {
            Artisan::call('make:model', ['name' => $modelClassName, '-m' => TRUE]);
            Artisan::call('make:repository', ['name' => $repositoryClassName]);
            Artisan::call('make:service', ['name' => $serviceClassName]);
            $userControllerChoice = $this->choice(
                'What do you want to publish against this class',
                [
                    'Api',
                    'Web',
                    'Both'
                ]
            );
            if($userControllerChoice == 'Api') {
                Artisan::call('make:controller', ['name' => $forApiControllerClassName]);
            }
            elseif($userControllerChoice == 'Web') {
                Artisan::call('make:controller', ['name' => $forWebControllerClassName]);
            }
            elseif($userControllerChoice == 'Both') {
                Artisan::call('make:controller', ['name' => $forApiControllerClassName]);
                Artisan::call('make:controller', ['name' => $forWebControllerClassName]);
            }
            $this->info("All files are created successfully");
        }
        elseif ($userChoice ==  'Model Migration Seeder') {
            Artisan::call('make:model', ['name' => $modelClassName, '-m' => TRUE, '--seed' => TRUE]);
            $this->info("Files are created successfully");
        }

        elseif ($userChoice ==  'Model Migration Seeder Repository') {
            Artisan::call('make:model', ['name' => $modelClassName, '-m' => TRUE, '--seed' => TRUE]);
            Artisan::call('make:repository', ['name' => $repositoryClassName]);
            $this->info("Files are created successfully");
        }
        elseif ($userChoice ==  'Model Migration Seeder Repository Service') {
            Artisan::call('make:model', ['name' => $modelClassName, '-m' => TRUE, '--seed' => TRUE]);
            Artisan::call('make:repository', ['name' => $repositoryClassName]);
            Artisan::call('make:service', ['name' => $serviceClassName]);
            $this->info("Files are created successfully");
        }
        elseif ($userChoice ==  'Controller Service') {
            Artisan::call('make:service', ['name' => $serviceClassName]);
            $userControllerChoice = $this->choice(
                'What do you want to publish against this class',
                [
                    'Api',
                    'Web',
                    'Both'
                ]
            );
            if($userControllerChoice == 'Api') {
                Artisan::call('make:controller', ['name' => $forApiControllerClassName]);
            }
            elseif($userControllerChoice == 'Web') {
                Artisan::call('make:controller', ['name' => $forWebControllerClassName]);
            }
            elseif($userControllerChoice == 'Both') {
                Artisan::call('make:controller', ['name' => $forApiControllerClassName]);
                Artisan::call('make:controller', ['name' => $forWebControllerClassName]);
            }
            $this->info("Files are created successfully");
        }
    }
}
