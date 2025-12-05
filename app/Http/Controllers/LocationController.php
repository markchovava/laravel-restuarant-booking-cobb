<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    
    public function search(Request $request){
        $search = $request->search;
        if($search){
            $data = Location::with(['user'])
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(20);
            return LocationResource::collection($data);           
        }
        $data = Location::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return LocationResource::collection($data);
    }

    public function index(){
        $data = Location::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return LocationResource::collection($data);  
    }

    public function indexAll(){
        $data = Location::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->get();
        return LocationResource::collection($data); 
    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $data = new Location();
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->tablesTotal = $request->tablesTotal;
        $data->userId = $userId;
        $data->save();
        return response()->json([
            'data' => new LocationResource($data),
            'status' => 1,
            'message' => "Data saved successfully.",
        ]);
    }

    public function view($id){
        $data = Location::with(['user'])
                ->find($id);
        return new LocationResource($data);
    }

    public function update(Request $request, $id){
        Log::info('LOCATION');
        Log::info($request);
        $userId = Auth::user()->id;
        $data = Location::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->tablesTotal = $request->tablesTotal;
        $data->status = $request->status;
        $data->userId = $userId;
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'data' => new LocationResource($data),
            'status' => 1,
            'message' => 'Data saved successfully.'
        ]);
    }

    public function delete($id){
        $data = $data = Location::find($id);
        $data->delete();
        return response()->json([
            'message' => 'Data deleted successfully.',
            'status' => 1
        ]);
    }

}
