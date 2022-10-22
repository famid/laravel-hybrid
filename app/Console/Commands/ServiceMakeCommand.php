<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Exception\InvalidArgumentException;


class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $serviceClass;

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $repository;

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws FileNotFoundException
     */

    public function fire(): ?bool {

        $this->setServiceClass();

        $path = $this->getPath($this->serviceClass);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->serviceClass));

        $this->info($this->type.' created successfully.');

        $this->line("<info>Created Service :</info> $this->serviceClass");
    }

    /**
     * Set service class name
     *
     * @return  void
     */
    private function setServiceClass(): void {
        $name = ucwords(strtolower($this->argument('name')));

        $this->repository = $name;

        $repositoryClass = $this->parseName($name);

        $this->serviceClass = $repositoryClass . 'Service';

    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name): string {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument service name");
        }

        $stub = parent::replaceClass($stub, $name);
        $serviceClassName = explode("/", $this->argument('name'));
        $serviceClassName = $serviceClassName[count($serviceClassName) - 1];
        $this->repository = str_replace("Service", "", $serviceClassName)."Repository";
        $featureName = str_replace("Service", "", $serviceClassName);
        return str_replace(
            ['RepositoryClassName', 'repositoryName', 'FeatureName', 'featureName'],
            [$this->repository, lcfirst($this->repository), $featureName, lcfirst($featureName)],
            $stub);
    }

    /**
     *
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string {
        return  base_path('stubs/service.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string {
        return $rootNamespace . '\Http\Services';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository class.'],
        ];
    }
}
