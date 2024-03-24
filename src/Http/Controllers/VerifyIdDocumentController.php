<?php

namespace Fintech\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Fintech\Auth\Http\Requests\VerifyIdDocTypeRequest;
use Fintech\Auth\Http\Resources\VerifyIdDocTypeResource;
use Illuminate\Http\JsonResponse;

class VerifyIdDocumentController extends Controller
{
    /**
     * @lrd:start
     * Verify *IdDocType* is already exists or not in storage.
     * @lrd:end
     *
     * @param VerifyIdDocTypeRequest $request
     * @return VerifyIdDocTypeResource|JsonResponse
     */
    public function __invoke(VerifyIdDocTypeRequest $request): VerifyIdDocTypeResource|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $idDocType = \Fintech\Auth\Facades\Auth::profile()->list($inputs);

            return new VerifyIdDocTypeResource($idDocType);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
