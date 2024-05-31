<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'area'
    ];
}
