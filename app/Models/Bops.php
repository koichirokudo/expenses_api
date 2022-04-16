<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bops extends Model
{
    use HasFactory;

    protected $fillable = [
        'bop_id',
        'bop_name',
    ];
}
