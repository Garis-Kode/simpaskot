<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DumpingPlace extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'dumping_places';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'address',
        'latitude',
        'longitude',
        'volume',
    ];

    public function location()
    {
        return $this->hasMany(Location::class);
    }
}
