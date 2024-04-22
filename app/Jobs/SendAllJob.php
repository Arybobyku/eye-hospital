<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\NewTradeAll;

class SendAllJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
		public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
      $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      event(new NewTradeAll($this->data));
    }
}
