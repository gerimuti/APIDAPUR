<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'resep';
    protected $primaryKey = 'id_resep';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_masakana',
        'penjelasaan',
        'waktumemasak',
        'kategori',
        'rincian_bahan',
        'cara_memasak'
    ];
}
