<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberPhotos extends Model
{
    use HasFactory;

    protected $table = 'barbersphotos';
    public $timestamps = false;
}
