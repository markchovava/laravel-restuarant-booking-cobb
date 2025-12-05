<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppInfoResource;
use App\Models\AppInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppInfoController extends Controller
{
    
    public function store(Request $request){
        $userId = Auth::user()->id ?? $request->userId;
        $data = AppInfo::first();
    
        if(!isset($data)) {
            $data = AppInfo::create(array_merge(
                $request->only([
                    'name', 
                    'phone', 
                    'email', 
                    'address', 
                    'description', 
                    'website', 
                    'facebook', 
                    'instagram',
                    'whatsapp'
                ]),
                ['userId' => $userId]
            ));
            return response()->json([
                'status' => 1,
                'message' => 'Data successfully saved.',
                'data' => new AppInfoResource($data),
            ]);
        }
        
        $data->update(array_merge(
            $request->only([
                'name', 
                'phone', 
                'email', 
                'address', 
                'description', 
                'website', 
                'facebook', 
                'instagram',
                'whatsapp'
            ]),
            ['userId' => $userId]
        ));
    
        // Log::info($data);
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully saved.',
            'data' => new AppInfoResource($data),
        ]);
    }

    public function view(){
        $data = AppInfo::with(['user'])->first();
        if(!isset($data)) {
            return response()->json([
                'data' => ''
            ]);
        }
        return new AppInfoResource($data);
       
    }

}
