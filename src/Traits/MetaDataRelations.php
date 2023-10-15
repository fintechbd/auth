<?php


namespace Fintech\Auth\Traits;

use Fintech\Core\Facades\Core;

if (Core::packageExists('MetaData')) {
    trait MetaDataRelations
    {
        /**
         * Permanent Address
         */
        public function country()
        {
            return $this->belongsTo(config('fintech.metadata.country_model'));
        }

        public function state()
        {
            return $this->belongsTo(config('fintech.metadata.state_model'));
        }

        public function city()
        {
            return $this->belongsTo(config('fintech.metadata.city_model'));
        }

        /**
         * Present Address
         */
        public function presentCountry()
        {
            return $this->belongsTo(config('fintech.metadata.country_model'), 'present_country_id');
        }

        public function presentState()
        {
            return $this->belongsTo(config('fintech.metadata.state_model'), 'present_state_id');
        }

        public function presentCity()
        {
            return $this->belongsTo(config('fintech.metadata.city_model'), 'present_city_id');
        }

    }
} else {
    trait MetaDataRelations
    {

    }
}
