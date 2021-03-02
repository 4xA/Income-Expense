<?php

namespace App;

use Parental\HasParent;

class Expense extends BalanceEntry
{
    use HasParent;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
