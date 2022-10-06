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
        'kode_mata_kuliah'
    ];
}
