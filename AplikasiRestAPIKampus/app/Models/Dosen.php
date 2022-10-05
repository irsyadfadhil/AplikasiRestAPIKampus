<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'nama',
        'nip',
        'kode_mata_kuliah',
        'username',
        'password',
    ];
}
