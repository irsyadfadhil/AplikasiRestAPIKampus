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
        //get posts
        $MataKuliahs = MataKuliah::latest()->paginate(5);

        //return collection of posts as a resource
        return new MataKuliahResource(true, 'List Data Posts', $MataKuliahs);
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
        $post = MataKuliah::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new MataKuliahResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    public function show(MataKuliah $MataKuliah)
    {
        //return single MataKuliah as a resource
        return new MataKuliahResource(true, 'Data MataKuliah Ditemukan!', $MataKuliah);
    }

    public function update(Request $request, MataKuliah $MataKuliah)
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
            $image->storeAs('public/MataKuliahs', $image->hashName());

            //update MataKuliah with new image
            $MataKuliah->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
            ]);

        } else {

            //update MataKuliah without image
            $MataKuliah->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

        //return response
        return new MataKuliahResource(true, 'Data MataKuliah Berhasil Diubah!', $MataKuliah);
    }

    public function destroy(MataKuliah $MataKuliah)
    {
        //delete MataKuliah
        $MataKuliah->delete();

        //return response
        return new MataKuliahResource(true, 'Data MataKuliah Berhasil Dihapus!', null);
    }
}
