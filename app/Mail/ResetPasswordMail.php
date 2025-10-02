<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $logoPath;

    public function __construct($password)
    {
        $this->password = $password;
        $this->logoPath = public_path('logo/lagologonew.png');
    }

    public function build()
    {
        return $this->subject('Contraseña Temporal - Lago Empleo')
            ->view('emails.password_temporal')
            ->with([
            'password' => $this->password,
            'logo' => $this->logoPath,
        ]);
    }

}
