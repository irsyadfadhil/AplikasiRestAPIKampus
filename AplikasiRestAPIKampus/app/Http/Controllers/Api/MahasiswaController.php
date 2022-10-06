<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $Mahasiswas = Mahasiswa::latest()->paginate(5);
        return new MahasiswaResource(true, 'List Data Mahasiswa', $Mahasiswas);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'nim'               => 'required',
            'kode_mata_kuliah'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $Mahasiswa = Mahasiswa::create([
            'nama'               => $request->nama,
            'nim'                => $request->nim,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
        ]);

        //return response
        return new MahasiswaResource(true, 'Data Mahasiswa Berhasil Ditambahkan!', $Mahasiswa);
    }

    public function show(Mahasiswa $Mahasiswa)
    {
        //return single Mahasiswa as a resource
        return new MahasiswaResource(true, 'Data Mahasiswa Ditemukan!', $Mahasiswa);
    }

    public function update(Request $request, Mahasiswa $Mahasiswa)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'              => 'required',
            'nim'               => 'required',
            'kode_mata_kuliah'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

         //update Mahasiswa without image
        $Mahasiswa->update([
            'nama'               => $request->nama,
            'nim'                => $request->nim,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
        ]);

        //return response
        return new MahasiswaResource(true, 'Data Mahasiswa Berhasil Diubah!', $Mahasiswa);
    }

    public function destroy(Mahasiswa $Mahasiswa)
    {
        //delete Mahasiswa
        $Mahasiswa->delete();

        //return response
        return new MahasiswaResource(true, 'Data Mahasiswa Berhasil Dihapus!', null);
    }
}
