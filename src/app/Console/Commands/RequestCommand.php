<?php

namespace sOne\Core\app\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class RequestCommand extends GeneratorCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'sone:core:make:request';

    /**
     * Description of the console command.
     *
     * @var string
     */
    protected $description = 'Create a new Form Request class within the package';

    /**
     * Type of the created class.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get a template to generate a class.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/request.stub';
    }

    /**
     * Get a directory to create the class in.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return RequestCommand . phpbase_path('packages/sonecms/sone-core/src/app/Http/Requests/') . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the request class'],
        ];
    }

    /**
     * Get the default namespace.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\app\Http\Requests';
    }
}
