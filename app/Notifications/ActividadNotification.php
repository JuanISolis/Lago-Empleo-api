<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Actividad;

class ActividadNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
    */

    protected $actividad;
    
    public function __construct(Actividad $actividad)
    {
        $this->actividad = $actividad;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
    */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->actividad->id,
            'tipo' => $this->actividad->tipo,
            'descripcion' => $this->actividad->descripcion,
            'rol' => $this->actividad->rol,
            'user_id' => $this->actividad->user_id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
    */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
