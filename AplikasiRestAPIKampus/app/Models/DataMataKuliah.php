<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMataKuliah extends Model
{
    use HasFactory;
    protected $table = 'data_mata_kuliah';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'nim',
        'nip',
        'kode_mata_kuliah',
        'kode_data_mata_kuliah'
    ];

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nip', 'nip');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nim', 'nim');
    }

    public function mata_kuliah()
    {
        return $this->hasOne(MataKuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
}
