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
        //get posts
        $dosens = Dosen::latest()->paginate(5);

        //return collection of posts as a resource
        return new DosenResource(true, 'List Data Posts', $dosens);
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
        $post = Dosen::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new DosenResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Dosen $dosen)
    {
        //return single dosen as a resource
        return new DosenResource(true, 'Data dosen Ditemukan!', $dosen);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Dosen $dosen)
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
            $image->storeAs('public/dosens', $image->hashName());

            //update dosen with new image
            $dosen->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
            ]);

        } else {

            //update dosen without image
            $dosen->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

        //return response
        return new DosenResource(true, 'Data dosen Berhasil Diubah!', $dosen);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Dosen $dosen)
    {
        //delete dosen
        $dosen->delete();

        //return response
        return new DosenResource(true, 'Data dosen Berhasil Dihapus!', null);
    }
}
