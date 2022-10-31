<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Vote;
use Illuminate\Console\Command;

class VoteDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:vote';

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
        // Vote::where([['updated_at', '<', Carbon::now()->subHours(10)]])->delete();
    }
}
