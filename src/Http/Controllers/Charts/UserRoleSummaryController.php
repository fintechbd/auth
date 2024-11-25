<?php

namespace Fintech\Auth\Http\Controllers\Charts;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Resources\Charts\UserRoleSummaryCollection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserRoleSummaryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $roles = Auth::role()->list([
            'id_not_in' => [1, 2],
            'count_user' => true,
            'paginate' => false,
        ]);

        return new UserRoleSummaryCollection($roles);
    }
}
