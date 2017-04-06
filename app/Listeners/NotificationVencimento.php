<?php

namespace App\Listeners;

use App\Events\MailNotification;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationVencimento
{

    /**
     * @var $mailer
     */
    protected $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  MailNotification  $event
     * @return void
     */
    public function handle(MailNotification $event)
    {
        $contratos = $event->contrato->toArray();

        foreach ($contratos as $contrato){
            $this->mailer->send('emails.vencimento', $contrato, function ($message) use ($contrato){
                foreach ($contrato['gestores'] as $gestor){
                    $message->to($gestor['email'])->subject('Aviso de Vencimento de Contrato');
                }
                foreach ($contrato['fiscais'] as $fiscal) {
                    $message->to($fiscal['email'])->subject('Aviso de Vencimento de Contrato');
                }
            });
        }
    }
}
