<?php

namespace App\Models;

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
        'type'
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'active' => 'boolean',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
