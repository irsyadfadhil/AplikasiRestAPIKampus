<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Http\Resources\DosenResource;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::latest()->paginate(5);
        return new DosenResource(true, 'List Data Dosen', $dosens);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'username'      => 'required',
            'nip'      => 'required',
            'kode_mata_kuliah'      => 'required',
            'password' => [
                'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dosen = Dosen::create([
            'nama'                  => $request->nama,
            'nip'                   => $request->nip,
            'kode_mata_kuliah'      => $request->kode_mata_kuliah,
            'username'              => $request->username,
            'password'              => bcrypt($request->password)
        ]);

        //return response
        return new DosenResource(true, 'Data Post Berhasil Ditambahkan!', $dosen);
    }

    public function show(Dosen $dosen)
    {
        //return single dosen as a resource
        return new DosenResource(true, 'Data dosen Ditemukan!', $dosen);
    }

    public function update(Request $request, Dosen $dosen)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'                  => 'required',
            'username'              => 'required',
            'nip'                   => 'required',
            'kode_mata_kuliah'      => 'required',
            'password' => [
                'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update dosen without image
        $dosen->update([
            'nama'                  => $request->nama,
            'nip'                   => $request->nip,
            'kode_mata_kuliah'      => $request->kode_mata_kuliah,
            'username'              => $request->username,
            'password'              => bcrypt($request->password)
        ]);

        //return response
        return new DosenResource(true, 'Data dosen Berhasil Diubah!', $dosen);
    }

    public function destroy(Dosen $dosen)
    {
        //delete dosen
        $dosen->delete();

        //return response
        return new DosenResource(true, 'Data dosen Berhasil Dihapus!', null);
    }
}
