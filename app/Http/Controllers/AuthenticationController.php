<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    //

    public function login(Request $request){

        $request->validate([
            'email' => 'required| email',
            'password' => 'required',
         ]);
   
         $user = User::where('email', $request->email)->first();
   
         if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message'=>'unathenticated',401]);
         }
         else{
         $token = $user->createToken($request->email)->plainTextToken;
         return response(["message"=>"success","token"=>"$token"]);
       
         }
        }
        
      public function getUser(Request $request){

        return $request->user();

      }
}
