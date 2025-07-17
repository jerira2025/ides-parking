<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DocumentoNotificado extends Notification
{
    use Queueable;

    protected $accion;
    protected $documento;

    public function __construct($accion, $documento)
    {
        $this->accion = $accion;
        $this->documento = $documento;
    }

    public function via($notifiable)
    {
        return ['database']; // o ['mail', 'database']
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => "El documento '{$this->documento->titulo}' fue {$this->accion} por " . auth()->user()->name,
            'documento_id' => $this->documento->id,
        ];
    }
}
