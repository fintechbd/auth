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
        public function permanentCountry(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.country_model'), 'permanent_country_id');
        }

        public function permanentState(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.state_model'), 'permanent_state_id');
        }

        public function permanentCity(): BelongsTo
        {
            return $this->belongsTo(config('fintech.metadata.city_model'), 'permanent_city_id');
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
