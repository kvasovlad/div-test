<?php

namespace App\Mail;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestResolved extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function build()
    {
        return $this->subject("Ваша заявка #{$this->request->id} была обработана")
            ->view('emails.request-resolved')
            ->with([
                'request' => $this->request,
            ]);
    }
}
