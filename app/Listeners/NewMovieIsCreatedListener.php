<?php

namespace App\Listeners;

use App\Events\NewMovieIsCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\MovieCreated;
use Illuminate\Support\Facades\Mail;



class NewMovieIsCreatedListener implements ShouldQueue
{
    

    /**
     * Handle the event.
     *
     * @param  NewMovieIsCreatedEvent  $event
     * @return void
     */
    public function handle(NewMovieIsCreatedEvent $event)
    {
        Mail::to('test@test.com')->send(new MovieCreated($event->movie, $event->fileName));
    }
}
