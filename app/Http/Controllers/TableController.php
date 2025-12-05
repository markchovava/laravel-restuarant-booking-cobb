<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableResource;
use App\Models\Booking;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TableController extends Controller
{

    public function indexByLocationId($id) {
        $data = Table::where('locationId', $id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->get();
        return TableResource::collection($data);
    }

    public function search(Request $request){
        $search = $request->search;
        if($search){
            $data = Table::with(['user', 'location'])
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(20);
            return TableResource::collection($data);           
        }
        return $this->index();
    }

    public function index(){
        $data = Table::with(['user', 'location'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return TableResource::collection($data);  
    }

    public function indexAll(){
        $data = Table::with(['user', 'location'])
                ->orderBy('updated_at', 'DESC')
                ->get();
        return TableResource::collection($data); 
    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $data = new Table();
        $data->userId = $userId;
        $data->name = $request->name;
        $data->locationId = $request->locationId;
        $data->seats = $request->seats;
        $data->quantity = $request->quantity;
        $data->status = $request->status;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'data' => new TableResource($data),
            'status' => 1,
            'message' => 'Data saved successfully.',
        ]);
    }

    public function view($id){
        $data = Table::with(['user', 'location'])
                ->find($id);
        return new TableResource($data);
    }

    public function update(Request $request, $id){
        $userId = Auth::user()->id;
        $data = Table::find($id);
        $data->name = $request->name;
        $data->seats = $request->seats;
        $data->quantity = $request->quantity;
        $data->locationId = $request->locationId;
        $data->status = $request->status;
        $data->updated_at = now();
        $data->userId = $userId;
        $data->save();
        return response()->json([
            'data' => new TableResource($data),
            'status' => 1,
            'message' => 'Data saved successfully.',
        ]);
    }

    public function delete($id){
        $data = $data = Table::find($id);
        $data->delete();
        return response()->json([
            'message' => 'Data deleted successfully.',
            'status' => 1
        ]);
    }

}
