<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulator extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'housing_value',
        'credit_amount',
        'credit_term',
        'full_name',
        'phone_number',
        'email'
    ];

    protected $casts = [
        'housing_value' => 'decimal:2',
        'credit_amount' => 'decimal:2',
        'credit_term' => 'decimal:2',
        'full_name'
    ];
}
