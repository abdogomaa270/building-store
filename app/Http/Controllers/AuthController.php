<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;



class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login','register','forgotpassword']]);
//    }

  public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8',
         ]);
    $credentials = $request->only(['email', 'password']);

    try {
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
            }
        }
        catch (JWTException $e) {
        return response()->json(['error' => 'Could not create token'], 500);
         }

    return response()->json(['status'=>'Success','token'=>$token],200);
    }
/*----------------------------------------------------------------------------------------*/
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',

        ]);

        $user =new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

//        try {
//            $token = JWTAuth::fromUser($user);
//        } catch (JWTException $e) {
//            return response()->json(['error' => 'Could not create token'], 500);
//        }

        return response()->json(['status' => 'Success','user'=>$user], 200);
    }
    /*--------------------------------------------------------------------------------*/

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /*-------------------------------------------------------------------------------*/
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    /*---------------------------------------------------------------------------------*/


    }

