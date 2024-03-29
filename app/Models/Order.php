<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'uuid',
        'total',
        'user_id',

        'name',
        'phone',
        'email',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class)->withDefault([
            'name' => 'Не выбрано',
        ]);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot([
                'price',
                'quantity',
                'total'
            ])->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => '—',
            'phone' => '—',
            'email' => '—',
        ]);
    }

    public function getPhoneFormatAttribute()
    {
        return phone_format($this->phone);
    }
}
