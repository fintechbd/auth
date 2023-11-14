<?php

namespace Fintech\Auth\Traits;

use Fintech\Core\Facades\Core;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

if (Core::packageExists('Business')) {
    trait BusinessRelations
    {
        /**
         * Permanent Address
         */
        public function services():BelongsToMany
        {
            return $this->belongsToMany(config('fintech.business.service_model'));
        }
    }
} else {
    trait BusinessRelations
    {
    }
}
