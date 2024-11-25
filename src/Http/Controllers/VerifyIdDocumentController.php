<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\VerifyIdDocTypeRequest;
use Fintech\Auth\Http\Resources\VerifyIdDocTypeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class VerifyIdDocumentController extends Controller
{
    /**
     * @lrd:start
     * Verify *IdDocType* is already exists or not in storage.
     *
     * @lrd:end
     */
    public function __invoke(VerifyIdDocTypeRequest $request): VerifyIdDocTypeResource|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $idDocType = Auth::profile()->findWhere($inputs);

            return new VerifyIdDocTypeResource($idDocType);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
