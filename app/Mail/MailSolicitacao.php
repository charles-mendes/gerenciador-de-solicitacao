<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSolicitacao extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $solicitacao = [];

    public function __construct($solicitacao)
    {
        $this->solicitacao = $solicitacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.solicitacao_pendente',['solicitacao'=> $this->solicitacao])
                    ->subject('Nova Solicitação Criada');
    }
}
