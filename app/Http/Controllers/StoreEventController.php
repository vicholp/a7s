<?php

namespace App\Http\Controllers;

use App\Jobs\StoreEventJob;
use Illuminate\Http\Request;

class StoreEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        StoreEventJob::dispatch($request);

        return 'OK';
    }
}
