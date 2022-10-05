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
        //get posts
        $Mahasiswas = Mahasiswa::latest()->paginate(5);

        //return collection of posts as a resource
        return new MahasiswaResource(true, 'List Data Posts', $Mahasiswas);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = Mahasiswa::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new MahasiswaResource(true, 'Data Post Berhasil Ditambahkan!', $post);
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
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/Mahasiswas', $image->hashName());

            //update Mahasiswa with new image
            $Mahasiswa->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
            ]);

        } else {

            //update Mahasiswa without image
            $Mahasiswa->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

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
