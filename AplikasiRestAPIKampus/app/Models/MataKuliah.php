<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'nama_mata_kuliah',
        'kode_mata_kuliah',
        'waktu_mata_kuliah',
    ];

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
}
