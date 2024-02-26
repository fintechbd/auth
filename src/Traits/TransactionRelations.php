<?php

namespace Fintech\Auth\Traits;

use Fintech\Core\Facades\Core;
use Fintech\Transaction\Models\UserAccount;
use Illuminate\Database\Eloquent\Relations\HasMany;

if (Core::packageExists('Transaction')) {
    trait TransactionRelations
    {
        public function userAccounts(): HasMany
        {
            return $this->hasMany(config('fintech.transaction.user_account_model', UserAccount::class));
        }
    }
} else {
    trait TransactionRelations
    {
    }
}
