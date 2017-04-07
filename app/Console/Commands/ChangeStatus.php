<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muda status do contrato de acordo com a data de vencimento';

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
        $hoje = Carbon::now()->toDateString();
        $contratos = DB::table('contratos')
            ->whereDate('encerramento', $hoje)
            ->update(['status' => 'F']);
    }
}
