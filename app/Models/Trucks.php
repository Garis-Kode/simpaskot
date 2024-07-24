<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trucks extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'trucks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'route_id',
        'garbage_truck_id',
    ];

    public function garbageTruck(): BelongsTo
    {
        return $this->belongsTo(GarbageTruck::class);
    }

    public function dumpingPlace(): BelongsTo
    {
        return $this->belongsTo(DumpingPlace::class);
    }
}
