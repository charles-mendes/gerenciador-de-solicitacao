<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailDiretoria extends Mailable
{
    use Queueable, SerializesModels;

    private $solicitacao = [];
    private $usuario = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitacao,$usuario)
    {
        $this->solicitacao = $solicitacao;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.solicitacao_diretoria',['solicitacao'=> $this->solicitacao , 'usuario' => $this->usuario])
                    ->subject('Solicitação do Setor de Compras esperando Aprovação.');

    }
}
