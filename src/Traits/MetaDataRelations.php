<?php

namespace Fintech\Auth\Traits;

use Fintech\Core\Facades\Core;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

if (Core::packageExists('MetaData')) {
    trait MetaDataRelations
    {
        /**
         * Permanent Address
         */
        public function country(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.country_model'));
        }

        public function state(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.state_model'));
        }

        public function city(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.city_model'));
        }

        /**
         * Present Address
         */
        public function presentCountry(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.country_model'), 'present_country_id');
        }

        public function presentState(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.state_model'), 'present_state_id');
        }

        public function presentCity(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.city_model'), 'present_city_id');
        }

    }
} else {
    trait MetaDataRelations
    {
    }
}
