<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleBookingResource;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\ScheduleBooking;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ScheduleBookingController extends Controller
{
    
    public function generateRandomText($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }

    
    public function indexByDateTimeSchedule(Request $request){
        $scheduleId = $request->scheduleId;
        $date = $request->date;
        $time = $request->time;
        $schedule = Schedule::find($scheduleId);
        if (!$schedule) {
            return response()->json([
                'status' => 0,
                'message' => 'Location / Floor not found.',
            ], 404);
        }
        $existingBookings = ScheduleBooking::where('date', $date)
                ->where('time', $request->time)
                ->where('scheduleId', $request->scheduleId)
                ->get();
        if($existingBookings->isEmpty()){
            $tables = Table::where('locationId', $schedule->locationId)->get();
            if($tables->isEmpty()){
                return response()->json([
                    'status' => 0,
                    'message' => 'No tables found for this location / floor.',
                ], 404);
            }
            $newBookings = [];
            foreach ($tables as $i) {
                $record = ScheduleBooking::create([
                    'tableId' => $i->id,
                    'locationId' => $schedule->locationId,
                    'scheduleId' => $scheduleId,
                    'tableName' => $i->name,
                    'locationName' => $schedule->name,
                    'seats' => $i->seats,
                    'status' => $i->status,
                    'tablesTotal' => $i->quantity,
                    'date' => $date,
                    'time' => $time,
                    'tablesTaken' => 0,
                ]);
                $newBookings[] = $record;
            }
            return response()->json([
                'data' => ScheduleBookingResource::collection($newBookings),
                'status' => 1,
                'message' => 'Tables added successfully.',
            ]);
        }
        return response()->json([
            'data' => ScheduleBookingResource::collection($existingBookings),
            'status' => 1,
            'message' => 'Tables found.',
        ]);
    }


    public function store(Request $request){
        $schedule = Schedule::find($request->scheduleId);
        if(!$schedule) {
            return response()->json([
                'data' => "",
                'message' => 'Data not found',
                'status' => 0
            ]);
        }
        $data = new ScheduleBooking();
        $data->locationId = $request->locationId;
        $data->tableId = $request->tableId; 
        $data->scheduleId = $request->scheduleId;  
        $data->locationName = $request->locationName;  
        $data->tableName = $request->tableName;  
        $data->date = $request->date;  
        $data->time = $request->time;  
        $data->quantity = $request->quantity;  
        $data->taken = $request->taken;  
        $data->status = $request->status;   
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();

        $schedule->tablesTaken += 1;
        $schedule->updated_at = now();
        $schedule->save();

        return response()->json([
            'data' => new ScheduleBookingResource($data),
            'message' => 'Data saved successfully.',
            'status' => 1,
        ]);
    }


    public function update(Request $request, $id) {        
        $data = ScheduleBooking::find($id);
        if (!$data) {
            return response()->json([
                'message' => 'Table not found.',
                'status' => 0,
            ], 404);
        }
        $data->taken = $request->taken;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->status = $request->status;
        $data->updated_at = now();
        $data->save();

        $bookings = Booking::where('scheduleBookingId', $id)->get();
        foreach($bookings as $i) {
            $bData = Booking::find($i->id);
            $bData->status = $request->status;
            $bData->updated_at = now();
            $bData->save();
        }
        // Mail::to(env('ADMIN_EMAIL'))->send(new ScheduleBookingMail($data));
        return response()->json([
            'data' => new ScheduleBookingResource($data),
            'message' => 'Data saved successfully.', 
            'status' => 1,
        ]);
    }


    public function search(Request $request) {
        if($request->search){
            $search = $request->search;
            $data = ScheduleBooking::where('tableName', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
            return ScheduleBookingResource::collection($data);
        }
        $data = ScheduleBooking::orderBy('updated_at', 'DESC')
                ->paginate(20);
        return ScheduleBookingResource::collection($data);
    }


    public function index() {
        $data = ScheduleBooking::orderBy('updated_at', 'DESC')->paginate(20);
        return ScheduleBookingResource::collection($data);
    }


    public function view($id) {
        $data = ScheduleBooking::with(['location', 'table', 'user', 'schedule'])
                ->find($id);
        if (!$data) {
            return response()->json([
                'message' => 'Booking not found.',
                'status' => 0,
                'data' => "",
            ], 404);
        }
        return new ScheduleBookingResource($data);
    }


    public function updateStatus(Request $request, $id) {
        $userId = Auth::user()->id;
        $data = ScheduleBooking::find($id);
        $data->status = $request->status;
        $data->userId = $userId;
        $data->updated_at = now();
        return response()->json([
            'status' => 1,
            'data' => new ScheduleBookingResource($data),
            'message' => 'Data saved successfully'
        ]);
    }


    public function delete($id) {
        Log::info('DELETE SCHEDULE BOOKING');
        Log::info($id);
        $data = ScheduleBooking::find($id);
        if (!$data) {
            return response()->json([
                'message' => 'Booking not found.',
                'status' => 0,
            ], 404);
        }

        $booking = Booking::where('scheduleBookingId', $data->scheduleBookingId)->first();
        if($booking) {
            $booking->delete();
        }

        $schedule = Schedule::find($data->scheduleId);
        if ($schedule) {
            $schedule->tablesTaken -= 1;
            $schedule->updated_at = now();
            $schedule->save();
        }

        $data->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully',
        ]);
    }

    
}
