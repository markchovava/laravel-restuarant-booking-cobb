<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableFloorPlanResource;
use App\Models\TableFloorPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TableFloorPlanController extends Controller
{
    
    public function indexAllWithBooking(){
        $data = TableFloorPlan::with(['table_booking_schedules'])
                ->orderBy('name', 'ASC')
                ->get();
        return TableFloorPlanResource::collection($data);
    }

    public function indexAll(){
        $data = TableFloorPlan::orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->get();
        return TableFloorPlanResource::collection($data);
    }
    
    public function indexByFloor(Request $request){
        $data = TableFloorPlan::with(['table_booking_schedules'])
                ->where('floor', $request->floor)
                ->orderBy('name', 'ASC')
                ->get();
        return TableFloorPlanResource::collection($data);
    }

    public function index(){
        $data = TableFloorPlan::with(['table_booking_schedules'])
                ->orderBy('name', 'ASC')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return TableFloorPlanResource::collection($data);
    }
    
    public function searchAll($search){
        if(!empty($search)) {
            $data = TableFloorPlan::where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
        } else {
            $data = TableFloorPlan::orderBy('name', 'ASC')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
        }
        return TableFloorPlanResource::collection($data);
    }

    public function search($search){
        if(!empty($search)) {
            $data = TableFloorPlan::where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('name', 'ASC')
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(20);
        } else {
            $data = TableFloorPlan::orderBy('name', 'ASC')
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(20);
        }
        return TableFloorPlanResource::collection($data);
    }

    public function storeAll(Request $request){
        $userId = Auth::user()->id;
        $now = Carbon::now();
        // We assume the request input contains an array of plan data under the key 'plans'.
        $plans = $request->input('plans', []);
        // The fields we allow to be mass assigned from the request
        // This prevents unauthorized columns from being inserted.
        $allowedFields = ['name', 'd', 'details', 'floor'];
        $preparedData = [];
        // Prepare the data array for the bulk insert
        foreach ($plans as $plan) {
            // Filter the incoming data to only include allowed fields
            $data = array_intersect_key($plan, array_flip($allowedFields));
            // Merge in the required user ID and timestamps
            $preparedData[] = array_merge($data, [
                'userId' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        // Perform the bulk insert using the insert() method for maximum efficiency.
        // NOTE: insert() bypasses model events and requires manual timestamp population.
        $success = TableFloorPlan::insert($preparedData);
        if ($success) {
            // A simple success response for bulk operations
            return response()->json([
                'status' => 1,
                'message' => count($preparedData) . ' records successfully saved in bulk.',
                // The insert method does not return the inserted models/IDs.
            ]);
        }
        return response()->json([
            'status' => 0,
            'message' => 'Failed to save records.',
        ], 500);
    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $data = TableFloorPlan::create(array_merge(
            $request->only([
                'name',
                'd',
                'details',
                'floor',
                'details'
            ]),
            ['userId' => $userId]
        ));
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully saved.',
            'data' => new TableFloorPlanResource($data),
        ]);
    }

    public function view($id){
        $data = TableFloorPlan::with(['user', 'table_booking_schedules'])->find($id);
        if(!isset($data)) {
            return response()->json([
                'data' => ""
            ]);
        }
        return new TableFloorPlanResource($data);
    }

    public function update(Request $request, $id){
        Log::info('UPDATE TableFloorPlan');
        Log::info($request);
        $userId = Auth::user()->id;
        $data = TableFloorPlan::find($id);
        $data->update(array_merge(
            $request->only([
                'name',
                'details',
            ]),
            ['userId' => $userId]
        ));
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully saved.',
            'data' => new TableFloorPlanResource($data),
        ]);
    }

    public function delete($id){
        $data = TableFloorPlan::find($id);
        if(!isset($data)){
            return response()->json([
                'message' => 'Table not found, deleted already.',
                'status' => 1,
                'data' => [],
        ]);
        }
        $data->delete();
        return response()->json([
            'message' => 'User deleted Successfully.',
            'status' => 1,
            'data' => []
        ]);
    }

}
