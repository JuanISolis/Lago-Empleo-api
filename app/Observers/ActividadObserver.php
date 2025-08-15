<?php

namespace App\Observers;

use App\Models\Actividad;
use App\Models\User;
use App\Notifications\ActividadNotification;

class ActividadObserver
{
    /**
     * Handle the Actividad "created" event.
    */

    public function created(Actividad $actividad)
    {
        switch ($actividad->tipo) {

            case 'oferta_publicada':
                
                $postulantes = User::where('rol', 'postulante')->get();
                foreach ($postulantes as $postulante) {
                    $postulante->notify(new ActividadNotification($actividad));
                }
                break;

            case 'postulacion_realizada':

                $empleador = User::find($actividad->user_id);
                if ($empleador) {
                    $empleador->notify(new ActividadNotification($actividad));
                }
                break;

            case 'perfil_actualizado':

                $empleadores = User::where('rol', 'empleador')->get();
                foreach ($empleadores as $empleador) {
                    $empleador->notify(new ActividadNotification($actividad));
                }
                break;

            case 'postulante_aceptado':

                $postulante = User::find($actividad->user_id);
                if ($postulante) {
                    $postulante->notify(new ActividadNotification($actividad));
                }
                break;

            default:

                break;
        }
    }

    /**
     * Handle the Actividad "updated" event.
     */
    public function updated(Actividad $actividad): void
    {
        //
    }

    /**
     * Handle the Actividad "deleted" event.
     */
    public function deleted(Actividad $actividad): void
    {
        //
    }

    /**
     * Handle the Actividad "restored" event.
     */
    public function restored(Actividad $actividad): void
    {
        //
    }

    /**
     * Handle the Actividad "force deleted" event.
     */
    public function forceDeleted(Actividad $actividad): void
    {
        //
    }
}
