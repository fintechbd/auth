<?php

namespace Fintech\Auth\Http\Controllers\Charts;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Resources\Charts\UserStatusSummaryCollection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserStatusSummaryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->mergeIfMissing([
            'role_id_not_in' => [1, 2],
            'count_user_status' => true,
            'paginate' => false,
            'sort' => 'count',
            'dir' => 'desc',
        ]);

        $users = Auth::user()->list($request->all());

        return new UserStatusSummaryCollection($users);
    }
}
