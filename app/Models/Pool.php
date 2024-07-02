<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'pools';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'address',
        'latitude',
        'longitude',
    ];
}
