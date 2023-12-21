<?php

namespace Fintech\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Fintech\Core\Enums\Auth\ProofOfAddressType;
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

            foreach (ProofOfAddressType::toArray() as $key => $status) {
                $entries->push([
                    'label' => ucwords(str_replace("_", " ", preg_replace('/(?<!^)[A-Z]/', '_$0', $status))),
                    'attribute' => $key
                ]);
            }

            return new DropDownCollection($entries);

        } catch (Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }
}
