<?php

namespace App\Models;

use App\Models\Route;
use App\Models\DumpingPlace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'locations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'route_id',
        'dumping_place_id',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function dumpingPlace(): BelongsTo
    {
        return $this->belongsTo(DumpingPlace::class);
    }
}
