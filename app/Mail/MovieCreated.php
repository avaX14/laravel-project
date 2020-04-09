<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MovieCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $movie;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($movie, $fileName)
    {
        $this->movie = $movie;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.movie-created')->subject("New Movie Is Created");
    }
}
