<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOneWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:delete-bought-last-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '去掉上周之前买的购买授权';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('开始删除');

        $rs = \DB::table('user_topic')->where('created_at','<',Carbon::today()->subDays(7)->toDateTimeString())->delete();

        $this->info("删除了 $rs 条记录.");
    }
}
