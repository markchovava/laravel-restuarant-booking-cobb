<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function generateRandomText($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }

    public function search($search) {
        $userId = Auth::user()->id;
        if(!empty($search)){
            $data = User::where('id', '!=', $userId)
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(20);
            return UserResource::collection($data);
        }
        $this->index();
    }

    public function indexAll() {
        $userId = Auth::user()->id;
        $data = User::where('id', '!=', $userId)
            ->orderBy('updated_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();
        return UserResource::collection($data);
    }

    public function index() {
        $userId = Auth::user()->id;
        $data = User::where('id', '!=', $userId)
            ->orderBy('updated_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->paginate(20);
        return UserResource::collection($data);
    }

    public function store(Request $request) {
        $email = User::where('email', $request->email)->first();
        if(isset($email)) {
            return response()->json([
                'message' => "Email already taken, try another one.",
                'status' => 0,
            ]);
        }
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->roleLevel = $request->roleLevel;
        $data->isAdmin = $request->isAdmin;
        $data->code = $this->generateRandomText(8);
        $data->password = Hash::make($data->code);
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        /*  */
        return response()->json([
            'message' => 'User saved Successfully.',
            'status' => 1,
            'data' => new UserResource($data)
        ]);
    }

    public function update(Request $request, $id){
        $email = User::where('id', '!=', $id)
            ->where('email', $request->email)
            ->first();
        if(isset($email)){
            return response()->json([
                'status' => 0,
                'message' => 'Email already exists, try another one.',
                'data' => []
            ]);
        }
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->roleLevel = $request->roleLevel;
        $data->isAdmin = $request->isAdmin;
        $data->address = $request->address;
        $data->updated_at = now();
        $data->save();
        /*  */
        return response()->json([
            'message' => 'User saved Successfully.',
            'status' => 1,
            'data' => new UserResource($data)
        ]);
    }

    public function view($id) {
        $data = User::find($id);
        return new UserResource($data);
    }

    public function delete($id) {
        $data = User::find($id);
        $data->delete();
        return response()->json([
            'message' => 'User deleted Successfully.',
            'status' => 1,
            'data' => ''
        ]);

    }


}
