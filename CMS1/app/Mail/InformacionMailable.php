<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformacionMailable extends Mailable
{
    use Queueable, SerializesModels;

    //Asunto del email
    public $subject = "Información de E-commerce";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $users_id = auth()->user()->id;
        $pedido = Pedido::where('users_id', '=', $users_id)->latest()->first();
        return $this->view('emails.informacion', compact('pedido'));
    }
}
