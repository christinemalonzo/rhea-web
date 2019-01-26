<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Users;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function forget(Request $request)
    {

        $password = $request->password;

        $token = bcrypt($request->token);
        $tokenData = DB::table('password_resets')
            ->where('token', $token)->first();
        dd($token);
        $user = Users::where('email', $tokenData->email)->first();
        if ( !$user ) return redirect()->to('home');

        $user->password = Hash::make($password);
        $user->update(); //or $user->save();
        DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect('/login');
    }
}
