<?php

namespace App\Console\Commands;

use App\Events\MailNotification;
use Illuminate\Console\Command;
use App\Repositories\Application\Contracts\ContratoRepository;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email para gestores e fiscais';

    /**
     * @var $contrato
     */
    protected $contrato;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContratoRepository $contratoRepository)
    {
        parent::__construct();
        $this->contrato = $contratoRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contratos = $this->contrato->getAllByVencimentoMail();

        event(new MailNotification($contratos));
    }
}
