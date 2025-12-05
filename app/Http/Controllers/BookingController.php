<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\ScheduleBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class BookingController extends Controller
{

    public function generateRandomText($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }


    public function store(Request $request) {
        $data = new Booking();
        $data->bookingRef = 'REF' . date('Ymd') . $this->generateRandomText(6);
        $data->locationId = $request->locationId;
        $data->scheduleId = $request->scheduleId;
        $data->scheduleBookingId = $request->scheduleBookingId;
        $data->tableId = $request->tableId;
        $data->tableName = $request->tableName;
        $data->locationName = $request->locationName;
        $data->fullName = $request->fullName;
        $data->notes = $request->notes;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->guests = $request->guests;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        /*  */
        $sbData = ScheduleBooking::find($data->scheduleBookingId);
        if($sbData->taken + 1 >= $sbData->quantity){
            $sbData->status = 'Reserved';
        }
        $sbData->taken += 1;
        $sbData->updated_at = now();
        $sbData->save();
        /*  */
        $schedule = Schedule::find($data->scheduleId);
        if($schedule->tablesTaken + 1 >= $schedule->total ){
            $schedule->status = 'Reserved';
        }
        $schedule->tablesTaken += 1;
        $schedule->updated_at = now();
        $schedule->save();
        Log::info('Schedule');
        Log::info($schedule);
        /*  */
        Mail::to(env('ADMIN_EMAIL'))->send(new BookingMail($data));
        /*  */
        return response()->json([
            'message' => 'Data saved successfully.',
            'data' => new BookingResource($data),
            'status' => 1,
        ]);
    }


    public function index() {
        $data = Booking::with(['user', 'schedule', 'location'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return BookingResource::collection($data);
    }


    public function indexAll() {
        $data = Booking::with(['user', 'schedule', 'location'])
                ->orderBy('updated_at', 'DESC')
                ->get();
        return BookingResource::collection($data);
    }


    public function search(Request $request) {
        $search = $request->search;
        if($search) {
            $data = Booking::with(['user', 'schedule', 'location'])
                ->where('bookingRef', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
            return BookingResource::collection($data);
        }
        $data = Booking::with(['user', 'schedule', 'location'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
        return BookingResource::collection($data);
    }


    public function view($id){
        $data = Booking::with(['user', 'schedule', 'location'])
                ->find($id);
        return new BookingResource($data);
    }


    public function update(Request $request, $id) {
        $data = Booking::find($id);
        $data->fullName = $request->fullName;
        $data->guests = $request->guests;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->notes = $request->notes;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'data' => new BookingResource($data),
            'message' => 'Data saved successfully.',
        ]);
    }


    public function updateStatus(Request $request, $id){
        $data = Booking::find($id);
        $data->status = $request->status;
        $data->userId = $request->status;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'message' => 'Data saved successfully.',
            'status' => 1,
            'data' => new BookingResource($data),
        ]);
    }

    public function delete($id) {
        $data = Booking::find($id);
        /*  */
        $sbData = ScheduleBooking::find($data->scheduleBookingId);
        $sbData->taken -= 1;
        $sbData->updated_at = now();
        $sbData->save();
        /*  */
        $schedule = Schedule::find($data->scheduleId);
        $schedule->tablesTaken -= 1;
        $schedule->updated_at = now();
        $schedule->save();
        $data->delete();
        return response()->json([
            'message' => 'Data deleted successfully.',
            'status' => 1,
        ]);
    }


}
