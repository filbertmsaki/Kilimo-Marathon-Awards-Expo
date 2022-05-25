<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\MarathonRegistration;

class DeleteIncompleRegistration extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registration:incomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete incomplete registration';

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

        MarathonRegistration::where([['paid', '=', 0], ['updated_at', '<', Carbon::now()->subMinutes(30)]])->delete();
    }
}
