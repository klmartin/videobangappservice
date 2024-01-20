<?php
/**
 
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


 
    public function login(Request $request){

        $request->validate([
            'email' => 'required| email',
            'password' => 'required',
         ]);
   
         $user = User::where('email', $request->email)->first();

         return $user;
   
        //  if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response('Login invalid', 503);
        //  }
   
        //  return $user->createToken($request->email)->plainTextToken;
      }

}