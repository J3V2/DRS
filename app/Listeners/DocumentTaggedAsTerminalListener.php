<?php

namespace App\Listeners;

use App\Events\DocumentTaggedAsTerminal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentTaggedAsTerminalListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentTaggedAsTerminal $event): void
    {
        //
    }
}
