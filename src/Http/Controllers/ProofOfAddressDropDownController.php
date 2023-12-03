<?php

namespace Fintech\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Fintech\Core\Http\Requests\DropDownRequest;
use Fintech\Core\Http\Resources\DropDownCollection;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ProofOfAddressDropDownController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param DropDownRequest $request
     * @return DropDownCollection|JsonResponse
     */
    public function __invoke(DropDownRequest $request): DropDownCollection|JsonResponse
    {
        try {
            $entries = collect();

            foreach (config('fintech.auth.proof_of_address_types', []) as $key => $status) {
                $entries->push(['label' => $status, 'attribute' => $key]);
            }

            return new DropDownCollection($entries);

        } catch (Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }
}
