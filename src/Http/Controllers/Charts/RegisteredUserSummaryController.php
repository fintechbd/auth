<?php

namespace Fintech\Auth\Http\Controllers\Charts;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegisteredUserSummaryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->success([
            'data' => [],
            'query' => $request->all(),
        ]);
    }
}
