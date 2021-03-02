<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;

class BalanceEntry extends Model
{
    use HasChildren, SoftDeletes;

    protected $childTypes = [
        'income' => Income::class,
    ];

    /**
     * The table name in database.
     *
     * @var string
     */
    protected $table = 'balance_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance', 'type', 'title', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
