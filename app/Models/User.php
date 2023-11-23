<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'city_id',
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
    ];

    protected $appends = [
        'phone_format',
    ];

    protected $with = [
        'city',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    const ROLES = [
        'admin' => 'Администратор',
        'supplier' => 'Поставщик',
        'dealer' => 'Дилер',
        'customer' => 'Клиент (покупатель)',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getPhoneFormatAttribute(): string|null
    {
        return phone_format($this->phone);
    }
}
