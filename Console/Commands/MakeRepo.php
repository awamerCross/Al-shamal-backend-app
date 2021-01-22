<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use File ;
use Illuminate\Console\Command;

class MakeRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name=name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create repos';

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
        File::copy('app/Repositories/Eloquent/copy.php',base_path('app/Repositories/Eloquent/'.$model.'Repository.php'));
        File::copy('app/Repositories/Interfaces/copy.php',base_path('app/Repositories/Interfaces/I'.$model.'.php'));
       
    }
}
