<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spots extends Model
{
    use HasFactory;

    public $timestamp = false;

    protected $fillable = [
        'regional_id',
        'name',
        'address',
        'serve',
        'capacity'
    ];
}
