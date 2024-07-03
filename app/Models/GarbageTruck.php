<?php

namespace App\Models;

use App\Models\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'volume',
        'type',
    ];
    
    public function routes()
    {
        return $this->hasMany(Route::class);
    }
}
