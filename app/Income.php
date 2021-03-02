<?php

namespace App;

use Parental\HasParent;

class Income extends BalanceEntry
{
    use HasParent;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
