<?php

namespace App\Models;

use App\Models\Pool;
use App\Models\Landfill;
use App\Models\Location;
use App\Models\GarbageTruck;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'routes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'garbage_truck_id',
        'pool_id',
        'landfill_id',
        'name',
    ];

    public function garbageTruck(): BelongsTo
    {
        return $this->belongsTo(GarbageTruck::class);
    }
    
    public function location()
    {
        return $this->hasMany(Location::class);
    }

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }

    public function landfill(): BelongsTo
    {
        return $this->belongsTo(Landfill::class);
    }
}
