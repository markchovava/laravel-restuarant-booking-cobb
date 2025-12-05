<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleBookingResource;
use App\Http\Resources\ScheduleResource;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\ScheduleBooking;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{

    public function storeAdminSchedule(Request $request) {
        $location = Location::find($request->locationId);
        if(!$location) {
            return response()->json([
                'data' => "",
                'message' => 'Location / Floor is not found.',
                'status' => 0,
            ]);
        }
        $schedule = Schedule::where('date', $request->date)
                ->where('time', $request->time)
                ->where('time', $request->locationId)
                ->first();
        if($schedule) {
            return response()->json([
                'status' => 3,
                'message' => 'Schedule is already added, edit in Schedule Bookings.',
                'data' => new ScheduleResource($schedule),
            ]);
        }
        $userId = Auth::user()->id;
        $schedule = new Schedule();
        $schedule->userId = $userId;
        $schedule->locationId = $request->locationId;
        $schedule->locationName = $request->locationName;
        $schedule->status = $request->status;
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->description = $location->description;
        $schedule->tablesTotal = $location->tablesTotal;
        $schedule->tablesTaken = $location->tablesTotal;
        $schedule->created_at = now();
        $schedule->updated_at = now();
        $schedule->save();
        /*  */
        $tables = Table::where('locationId', $request->locationId)->get();
        if( $tables->isEmpty() ){
            return response()->json([
                'data' => [],
                'message' => 'Tables is not found.',
                'status' => 2,
            ]);
        }
        $sbData = [];
        foreach($tables as $i) {
            $data = new ScheduleBooking();
            $data->userId = $userId;
            $data->locationId = $request->locationId;
            $data->tableName = $i->name;
            $data->taken = $i->quantity;
            $data->quantity = $i->quantity;
            $data->status = $request->status;
            $data->updated_at = now();
            $data->created_at = now();
            $data->save();
            /*  */
            $sbData[] = $data;
        }
        return response()->json([
            'status' => 1,
            'message' => "Data saved successfully.",
            'scheduleData' => new ScheduleResource($schedule),
            'scheduleBookingData' => ScheduleBookingResource::collection($sbData),
        ]);
    }

    public function index(){
        $data = Schedule::orderBy('updated_at', 'DESC')
                ->orderBy('locationName', 'ASC')
                ->paginate(20);
        return ScheduleResource::collection($data);
    }

    public function search(Request $request){
        if($request->search) {
            $search = $request->search;
            $data = Schedule::where('locationName', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('locationName', 'ASC')
                    ->paginate(20);
            return ScheduleResource::collection($data);
        }
        $data = Schedule::orderBy('updated_at', 'DESC')
                ->orderBy('locationName', 'ASC')
                ->paginate(20);
        return ScheduleResource::collection($data);
    }
   
    public function view($id){
        $data = Schedule::with(['user', 'location', 'schedule_bookings'])
                ->find($id);
        return new ScheduleResource($data);
    }

    public function updateStatus(Request $request, $id) {
        $userId = Auth::user()->id;
        $data = Schedule::find($id);
        $data->status = $request->status;
        $data->updated_at = now();
        $data->save();
        $sbData = ScheduleBooking::where('scheduleId', $data->scheduleId)->get();
        if($sbData->isNotEmpty()) {
            foreach($sbData as $i){
                $data = ScheduleBooking::find($i->id);
                $data->status = $request->status;
                $data->userId = $userId;
                $data->updated_at = now();
                $data->save();
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new ScheduleResource($data),
        ]);
    }

    public function indexByDateTime(Request $request) {
        if(!$request->date){
            return response()->json([
                'message' => 'Date is required.',
                'data' => '',
                'status' => 0,
            ]);
        }
        if(!$request->time){
            return response()->json([
                'message' => 'Time is required.',
                'data' => '',
                'status' => 0,
            ]);
        }
        $date = $request->date;
        $time = $request->time;  
        // Search for records
        $data = Schedule::where('date', $date)
            ->where('time', $time)
            ->get();
        // Return existing records if found
        if ($data->isNotEmpty()) {
            return response()->json([
                'message' => 'Records found.',
                'data' => ScheduleResource::collection($data),
                'status' => 1,
            ], 200);
        }
        // Create records if empty
        $locationData = Location::with('tables')->get(); // Eager load tables
        if ($locationData->isEmpty()) {
            return response()->json([
                'message' => 'Location not available, contact Support.',
                'data' => [],
                'status' => 0,
            ], 404); // Changed from 201 to 404
        }
        $data = [];
        foreach ($locationData as $location) {
            // Check if location has tables
            if ($location->tables->isEmpty()) {
                return response()->json([
                    'message' => 'No tables found for location: ' . $location->name,
                    'data' => [],
                    'status' => 0
                ], 404);
            }
            // Create schedule record
            $record = Schedule::create([
                'locationId' => $location->id,
                'locationName' => $location->name,
                'status' => $location->status,
                'date' => $date,
                'time' => $time,
                'tablesTotal' => $location->tablesTotal,
                'tablesTaken' => 0,
                'description' => $location->description,
            ]); 
            $data[] = $record;
            // Create schedule booking records for each table
            foreach ($location->tables as $table) {
                ScheduleBooking::create([
                    'scheduleId' => $record->id,
                    'locationId' => $location->id,
                    'tableId' => $table->id,
                    'locationName' => $location->name,
                    'tableName' => $table->name,
                    'quantity' => $table->quantity,
                    'taken' => 0, 
                    'date' => $date, 
                    'time' => $time, 
                    'status' => $table->status,
                ]);
            }
        }
        return response()->json([
            'message' => 'No records found. Created ' . count($data) . ' new records.',
            'data' => ScheduleResource::collection($data),
            'status' => 1,
        ], 201);
    }

    public function delete(Request $request){
        $date = $request->date;
        $time = $request->time;
        $id = $request->scheduleId;
        $scheduleBooking = ScheduleBooking::where('scheduleId', $id)
                ->where('date', $date)
                ->where('time', $time)
                ->first();
        if($scheduleBooking){
            $scheduleBooking->delete();
        }
        $booking = Booking::where('scheduleId', $id)
                ->where('date', $date)
                ->where('time', $time)
                ->first();
        if($booking){
            $booking->delete();
        }
        $data = Schedule::find($id);
        if($data) {
            $data->delete();
        }
        ///Log::info();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
            'data' => ''
        ]); 
    }
    
    
}
 