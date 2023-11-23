<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'name',
        'address',
        'phone',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($warehouse) {
            $warehouse->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault();
    }
}
