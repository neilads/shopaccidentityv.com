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

class GameAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'password',
        'price',
        'status',
        'server',
        'registration_type',
        'planet',
        'earring',
        'note',
        'thumb',
        'images'
    ];


    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
