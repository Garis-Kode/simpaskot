<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarbageTruck extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'garbage_trucks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'license_plate',
        'driver_name',
        'fuel_price',
        'type',
    ];
}
