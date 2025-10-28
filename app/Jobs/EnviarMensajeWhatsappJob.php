<?php

namespace App\Jobs;

use Modules\Wpbox\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Wpbox\Traits\Whatsapp; // 👈 importa el trait

class EnviarMensajeWhatsappJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Whatsapp; // 👈 usa el trait

    protected $message;

    /**
     * Crea una nueva instancia del Job.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Ejecuta el trabajo en segundo plano.
     */
    public function handle()
    {
        $this->sendCampaignMessageToWhatsApp($this->message);
    }
}
