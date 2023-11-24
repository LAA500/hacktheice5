<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'barcode',
        'weight',
    ];

    protected $with = [
        'category',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    const UNITS = [
        'PCS' => 'Штука (шт.)',
        'PKG' => 'Упаковка (уп.)',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function getImageAttribute($image)
    {
        if (is_null($image)) {
            return 'https://via.placeholder.com/350x350/EBDBDE/7A87B8';
        }

        return $image;
    }
}
