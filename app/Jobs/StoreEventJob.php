<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Request $request
    ) {
        $this->data = $request->all();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Event::create([
            'project' => $this->data['project'] ?? 'N/A',
            'name' => $this->data['name']  ?? 'N/A',
            'data' => $this->data['data']  ?? 'N/A',
        ]);
    }
}
