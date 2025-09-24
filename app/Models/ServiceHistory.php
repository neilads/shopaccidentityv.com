<?php

/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceHistory extends Model
{
    use HasFactory;

    protected $table = 'service_histories';

    protected $fillable = [
        'user_id',
        'game_service_id',
        'game_account',
        'game_password',
        'server',
        'amount',
        'price',
        'discount_code',
        'discount_amount',
        'status',
        'admin_note',
        'completed_at'
    ];

    protected $casts = [
        'amount' => 'integer',
        'price' => 'integer',
        'discount_amount' => 'decimal:2',
        'server' => 'integer',
        'completed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameService(): BelongsTo
    {
        return $this->belongsTo(GameService::class);
    }

}
