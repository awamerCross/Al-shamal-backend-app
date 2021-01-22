<?php

namespace App\Console\Commands;

use File ;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeRepoModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:semisection {name=name}';

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
        File::copy('app/Repositories/Eloquent/copy.php',base_path('app/Repositories/Eloquent/'.$model.'Repository.php'));
        File::copy('app/Repositories/Interfaces/copy.php',base_path('app/Repositories/Interfaces/I'.$model.'.php'));
        return $folderNmae ;
    }
}
