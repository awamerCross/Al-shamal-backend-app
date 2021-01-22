<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:section {name=name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('name');
        $folderNmae = strtolower(Str::plural(class_basename($model)));
        Artisan::call('make:model',['name' => 'Models/'.$model,'-m' => true]);
        Artisan::call('make:controller', ['name' => 'Admin/'.$model.'Controller']);
        File::makeDirectory('resources/views/admin/'.$folderNmae);
        File::copy('resources/views/admin/layout/partial/copy.blade.php',base_path('resources/views/admin/'.$folderNmae.'/index.blade.php'));
        File::copy('app/Repositories/Eloquent/copy.php',base_path('app/Repositories/Eloquent/'.$model.'Repository.php'));
        File::copy('app/Repositories/Interfaces/copy.php',base_path('app/Repositories/Interfaces/I'.$model.'.php'));
        return $folderNmae ;
       
        ////        Artisan::call('make:observer', ['name' => $model.'Observer']);

    }
}
