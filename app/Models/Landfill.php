<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landfill extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'landfills';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'address',
        'latitude',
        'longitude',
    ];
}
