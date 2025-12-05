<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request){
        $email = User::where('email', $request->email)->first();
        if(isset($email)){
            return response()->json([
                'message' => 'Email is aleady taken, please try another one.',
                'status' => 0,
            ]);
        }
        $data = new User();
        $data->isAdmin = 0;
        $data->roleLevel = 1;
        $data->email = $request->email;
        $data->code = $request->password;
        $data->password = Hash::make($request->password);
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Created Successfully.',
            'data' => new AuthResource($data),
        ]);
    }

    
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        /* Check Email... */
        if(!isset($user)){
            return response()->json([
                'message' => 'Email was not found.',
                'status' => 0,
            ]);
        }
        /* Check Password... */
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'The password is incorrect.',
                'status' => 2,
            ]);
        }
        /*  */
        return response()->json([
            'status' => 1,
            'message' => 'Login Successful.',
            'authToken' => $user->createToken($user->email)->plainTextToken,
            'data' => new AuthResource($user),
        ]);
    }


    public function password(Request $request){
        $user_id = Auth::user()->id ?? $request->user_id;
        $data = User::find($user_id);
        $data->code = $request->password;
        $data->password = Hash::make($request->password);
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Password updated successfully.',
            'data' => new AuthResource($data),
        ]);
    }


    public function view(){
        $user_id = Auth::user()->id;
        $data = User::find($user_id);
        return response()->json([
            'status' => 1,
            "message" => "",
            'data' => new AuthResource($data),
        ]);
    }


    public function update(Request $request){
        $user_id = Auth::user()->id ?? $request->user_id;
        $email = User::where('id', '!=', $user_id)
            ->where('email', $request->email)
            ->first();
        if(isset($email)){
            return response()->json([
                'status' => 0,
                'message' => 'Email already exists, try another one.',
                'data' => []
            ]);
        }
        $data = User::find($user_id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Profile updated successfully.',
            'data' => new AuthResource($data),
        ]);
    }
    

    public function email(Request $request){
        $user_id = Auth::user()->id;
        $email = User::where('id', '!=', $user_id)
            ->where('email', $request->email)
            ->first();
        if(isset($email)){
            return response()->json([
                'status' => 0,
                'message' => 'Email already exists, try another one.',
            ]);
        }
        $data = User::find($user_id);
        $data->email = $request->email;
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Email updated successfully.',
        ]);
    }


    public function logout() {
    $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not authenticated.',
            ]);
        } 
        $user->currentAccessToken()->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Logged out successfully.',
        ]);
    }
}
