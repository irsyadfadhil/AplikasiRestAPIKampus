<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'username'      => 'required',
            'nip'      => 'required',
            'kode_mata_kuliah'      => 'required',
            'email'     => 'required|email|unique:users',
            'role'      => 'required',
            // 'password'  => 'required|min:8||regex:/^[a-zA-Z]+$/u|confirmed'
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

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'     => $request->role,
            'username'              => $request->username,
            'password'  => bcrypt($request->password)
        ]);

        //create Dosen
        $dosen = Dosen::create([
            'nama'                  => $request->name,
            'nip'                   => $request->nip,
            'kode_mata_kuliah'      => $request->kode_mata_kuliah,
            'username'              => $request->username,
            'password'              => bcrypt($request->password)
        ]);


        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
