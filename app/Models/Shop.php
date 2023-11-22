<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'schedule',
    ];

    protected $casts = [
        'schedule' => 'json',
    ];

    protected $appends = [
        'phone_format',
    ];

    protected $with = [
        'products',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($shop) {
            $shop->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getPhoneFormatAttribute(): string|null
    {
        return phone_format($this->phone);
    }
}
