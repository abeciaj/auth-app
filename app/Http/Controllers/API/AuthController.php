<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Session;
use Redirect;


class AuthController extends Controller
{

    // Returns index.blade
    public function index()
    {
        return view('index');
    }

    // Returns login.blade
    public function signin()
    {
        return view('auth.login');
    }

    // Returns registration.blade
    public function signup()
    {
        return view('auth.register');
    }

    // Returns home.blade
    public function home()
    {
        // return auth()->user();
        return view('home', ['name' => auth()->user()->name]);
    }

    public function register(Request $request)
    {
        // Validation requirements
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        // Returns validation error
        if ($validator->fails()){
            return response()->json($validator->errors());       
        }

        // User creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        // Token generation
        $token = $user->createToken('auth_token')->plainTextToken;
        
        // Returns generated token
        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        // Returns if credentials is incorrect
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        // Generates new token when a user logs in
        $token = $user->createToken('auth_token')->plainTextToken;

        // return response()
        //     ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);

        return redirect()->route('home');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return Redirect::to('/');
    }

}
