<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function register(Request $request){
       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'access_token'=> Str::random(64)
        ]);
     return   response()->json($user);

    }







    public function login(Request $request){
    $is_exist =   Auth::attempt(['email' => $request->email, 'password' => $request->password]);

    if (!$is_exist ){
        $error = 'creditional  are not correct';
        return   response()->json($error);
    }

    $user = User::where('email', $request->email)->first();
    $new_access_token =  Str::random(64);

   $user->update([
    'access_token' => $new_access_token
   ]);
   return   response()->json($user->access_token);

    //     $users = User::create([
    //          'name' => $request->name,
    //          'email' => $request->email,
    //          'password' => Hash::make($request->password),
    //          'access_token'=> Str::random(64)
    //      ]);
    //   return   response()->json($users->access_token);

     }

    public function logout(Request $request){


        $access_token = $request->access_token;
        $user = User::where('access_token', $access_token)->first();
        if(! $user == null){
            $user->update([
                'access_token'=>NULL
            ]);
            $sucecc = 'token  are  correct';
            return   response()->json($sucecc);

        }
        $error = 'token  are not correct';
        return   response()->json($error);

    }
}
