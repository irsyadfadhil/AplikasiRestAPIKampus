<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataMataKuliah;
use App\Http\Resources\DataMataKuliahResource;
use Illuminate\Support\Facades\Validator;

class DataMataKuliahController extends Controller
{
    public function index()
    {
        $mata_kuliah = DataMataKuliah::latest()->paginate(5);
        return new DataMataKuliahResource(true, 'List Data Mata Kuliah', $mata_kuliah);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nim'     => 'required',
            'kode_mata_kuliah'     => 'required',
            'kode_data_mata_kuliah'     => 'required',
            'nip'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $mata_kuliah = DataMataKuliah::create([
            'nim'   => $request->nim,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
            'kode_data_mata_kuliah'   => $request->kode_data_mata_kuliah,
            'nip'   => $request->nip,
        ]);

        //return response
        return new DataMataKuliahResource(true, 'Data Mata Kuliah Berhasil Ditambahkan!', $mata_kuliah);
    }

    public function show(DataMataKuliah $DataMataKuliah)
    {
        //return single DataMataKuliah as a resource
        return new DataMataKuliahResource(true, 'Data Mata Kuliah Ditemukan!', $DataMataKuliah);
    }

    public function update(Request $request, DataMataKuliah $mata_kuliah)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nim'     => 'required',
            'kode_mata_kuliah'     => 'required',
            'kode_data_mata_kuliah'     => 'required',
            'nip'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update DataMataKuliah without image
        $mata_kuliah->update([
            'nim'   => $request->nim,
            'kode_mata_kuliah'   => $request->kode_mata_kuliah,
            'kode_data_mata_kuliah'   => $request->kode_data_mata_kuliah,
            'nip'   => $request->nip,
        ]);

        //return response
        return new DataMataKuliahResource(true, 'Data Mata Kuliah Berhasil Diubah!', $mata_kuliah);
    }

    public function destroy(DataMataKuliah $DataMataKuliah)
    {
        //delete DataMataKuliah
        $DataMataKuliah->delete();

        //return response
        return new DataMataKuliahResource(true, 'Data Mata Kuliah Berhasil Dihapus!', null);
    }
}
