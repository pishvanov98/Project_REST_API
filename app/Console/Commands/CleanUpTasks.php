<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanUpTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CleanUpTasks {--date_lte=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Чистка задач';

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

        if(!empty($this->option('date_lte')) && date('Y-m-d', strtotime($this->option('date_lte'))) == $this->option('date_lte')){
            $date = $this->option('date_lte');

        }else{
            $date=Carbon::now()->modify('-30 days')->toDateString();
        }
        $this->info($date);

       $db = DB::table('tasks')->whereDate('updated_at','<',$date)->where('status','=','backlog')->delete();

        $this->info('Удаленные записи в количестве - '. $db);

        Log::channel('command')->info('Команда выполнена');

        return '';
    }
}
