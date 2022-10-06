<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Http\Resources\MataKuliahResource;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mata_kuliah = MataKuliah::latest()->paginate(5);
        return new MataKuliahResource(true, 'List Data Mata Kuliah', $mata_kuliah);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_mata_kuliah'     => 'required',
            'kode_mata_kuliah'     => 'required',
            'waktu_mata_kuliah'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $mata_kuliah = MataKuliah::create([
            'nama_mata_kuliah'   => $request->nama_mata_kuliah,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
            'waktu_mata_kuliah'   => $request->waktu_mata_kuliah,
        ]);

        //return response
        return new MataKuliahResource(true, 'Data Mata Kuliah Berhasil Ditambahkan!', $mata_kuliah);
    }

    public function show(MataKuliah $MataKuliah)
    {
        //return single MataKuliah as a resource
        return new MataKuliahResource(true, 'Data Mata Kuliah Ditemukan!', $MataKuliah);
    }

    public function update(Request $request, MataKuliah $mata_kuliah)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_mata_kuliah'     => 'required',
            'kode_mata_kuliah'     => 'required',
            'waktu_mata_kuliah'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update MataKuliah without image
        $mata_kuliah->update([
            'nama_mata_kuliah'   => $request->nama_mata_kuliah,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
            'waktu_mata_kuliah'   => $request->waktu_mata_kuliah,
        ]);

        //return response
        return new MataKuliahResource(true, 'Data Mata Kuliah Berhasil Diubah!', $mata_kuliah);
    }

    public function destroy(MataKuliah $MataKuliah)
    {
        //delete MataKuliah
        $MataKuliah->delete();

        //return response
        return new MataKuliahResource(true, 'Data Mata Kuliah Berhasil Dihapus!', null);
    }
}
