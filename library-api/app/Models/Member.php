<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'members';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'member_code',
        'email',
        'phone',
        'address',
        'status',
        'joined_at',
    ];
}