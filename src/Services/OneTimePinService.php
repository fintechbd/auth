<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\OneTimePinRepository;

/**
 * Class PermissionService
 *
 */
class OneTimePinService
{
    /**
     * @var OneTimePinRepository
     */
    private OneTimePinRepository $oneTimePinRepository;

    /**
     * OneTimePinService constructor.
     * @param OneTimePinRepository $oneTimePinRepository
     */
    public function __construct(OneTimePinRepository $oneTimePinRepository)
    {
        $this->oneTimePinRepository = $oneTimePinRepository;
    }

    public function create(string $inputs)
    {
        return $this->oneTimePinRepository->create($inputs);
    }

    //    public function find($id, $onlyTrashed = false)
    //    {
    //        return $this->oneTimePinRepository->find($id, $onlyTrashed);
    //    }
    //
    //    public function update($id, array $inputs = [])
    //    {
    //        return $this->oneTimePinRepository->update($id, $inputs);
    //    }
    //
    //    public function destroy($id)
    //    {
    //        return $this->oneTimePinRepository->delete($id);
    //    }
    //
    //    public function restore($id)
    //    {
    //        return $this->oneTimePinRepository->restore($id);
    //    }
}
