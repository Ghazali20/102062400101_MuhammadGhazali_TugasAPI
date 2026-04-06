<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional jika nama tabel adalah jamak dari nama model)
     */
    protected $table = 'books';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'publisher',
        'year',
        'stock',
        'description',
    ];
}