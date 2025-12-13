<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration_days',
        'visits_limit',
        'price_cents',
        'currency',
        'active',
        'type',
        'base_benefits',
    ];

    protected $casts = [
        'base_benefits' => 'array',
        'price_cents' => 'integer',
        'active' => 'boolean',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['price_cents'] / 100,
            set: fn ($value) => ['price_cents' => $value * 100],
        );
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
