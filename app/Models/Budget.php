<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'user_id',
        'bop_id',
        'date',
        'category_id',
        'note',
        'money',
        'split_bill',
        'share',
    ];
}
