<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableBookingScheduleResource;
use App\Http\Resources\TableFloorPlanResource;
use App\Mail\BookingAdminMail;
use App\Models\TableBookingSchedule;
use App\Models\TableFloorPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TableBookingScheduleController extends Controller
{

    public $perPage = 20;

    public function generateRandomText($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }


    public function indexByDateTime(Request $request){
        $tablesData = TableFloorPlan::orderBy('id', 'ASC')
                ->get();
        if( $request->filled('date') && $request->filled('time') ) {
            $schedulesData = TableBookingSchedule::orderBy('id', 'ASC')
                    ->where('date', $request->date)
                    ->where('time', $request->time)
                    ->get();
            if ($schedulesData->isEmpty()) {
                // Handle empty case
                 return response()->json([
                    'tablesData' => TableFloorPlanResource::collection($tablesData),
                    'schedulesData' => [],
                    'status' => 3 
                ]);
            }
            return response()->json([
                'tablesData' => TableFloorPlanResource::collection($tablesData),
                'schedulesData' => TableBookingScheduleResource::collection($schedulesData),
                'status' => 1
            ]);
        } 
        return response()->json([
            'tablesData' => TableFloorPlanResource::collection($tablesData),
            'schedulesData' => [],
            'status' => 2
        ]);

    }


    public function indexByFloorDate($floor, $date){
        if(!empty($floor) && !empty($date)) {
            $tableFloorPlanIds = TableFloorPlan::where('floor', $floor)
                            ->pluck('id');
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->whereIn('tableFloorPlanId', $tableFloorPlanIds)
                ->where('date', $date)
                ->paginate($this->perPage);
            return response()->json([
                'status' => 1,
                'data' => TableBookingScheduleResource::collection($data),
            ]);
        }
        return response()->json([
            'status' => 0,
            'data' => [],
        ]);
    }
    
    public function indexByFloorTime($floor, $time){
        if(!empty($floor) && !empty($time)) {
            $tableFloorPlanIds = TableFloorPlan::where('floor', $floor)
                            ->pluck('id');
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->whereIn('tableFloorPlanId', $tableFloorPlanIds)
                ->where('time', $time)
                ->paginate($this->perPage);
            return response()->json([
                'status' => 1,
                'data' => TableBookingScheduleResource::collection($data),
            ]);
        }
        return response()->json([
            'status' => 0,
            'data' => [],
        ]);
    }

    public function indexByFloorStatus($floor, $status){
        if(!empty($floor) && !empty($status)) {
            $tableFloorPlanIds = TableFloorPlan::where('floor', $floor)
                            ->pluck('id');
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->whereIn('tableFloorPlanId', $tableFloorPlanIds)
                ->where('status', $status)
                ->paginate($this->perPage);
            return response()->json([
                'status' => 1,
                'data' => TableBookingScheduleResource::collection($data),
            ]);
        }
        return response()->json([
            'status' => 0,
            'data' => [],
        ]);
    }

    public function indexByDate($date){
        if(!empty($date)) {
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->where('date', $date)
                ->paginate($this->perPage);
            return response()->json([
                'status' => 1,
                'data' => TableBookingScheduleResource::collection($data),
            ]);
        }
        return response()->json([
            'status' => 0,
            'data' => [],
        ]);
    }
   
    public function indexByStatus($status){
        if(!empty($status)) {
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->where('status', $status)
                ->paginate($this->perPage);
            return response()->json([
                'status' => 1,
                'data' => TableBookingScheduleResource::collection($data),
            ]);
        }
        return response()->json([
            'status' => 0,
            'data' => [],
        ]);
    }

    public function index(){
        $data = TableBookingSchedule::with(['table_floor_plan'])
            ->orderBy('updated_at', 'DESC')
            ->paginate($this->perPage);
        return TableBookingScheduleResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = TableBookingSchedule::with(['table_floor_plan'])
                ->where('bookingRef', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'DESC')
                ->paginate($this->perPage);
            return TableBookingScheduleResource::collection($data);
        }
        return $this->index();
    }

    public function view($id){ 
        $data = TableBookingSchedule::with(['user', 'table_floor_plan'])
            ->find($id);
        return new TableBookingScheduleResource($data);
    }

    public function store(Request $request){ 
        
        $data = TableBookingSchedule::create(array_merge(
            $request->only([
                'userId',
                'tableFloorPlanId',
                'date',
                'time',
                'status',
                'css',
                'fullName',
                'email',
                'phone',
                'numberOfGuests',
                'notes',
            ]),
            ['bookingRef' => 'REF' . date('Ymd') . $this->generateRandomText(7)]
        ));
        /*Log::Info('Table Booking Schedule');
        Log::Info($data); */
        Mail::to(env('ADMIN_EMAIL'))->send(new BookingAdminMail($data));
        //Mail::to('info@cobblestonezw.com')->send(new BookingAdminMail($data));
        return response()->json([
            'status' => 1,
            'message' => "Booking submitted successfully, check you email for more info.",
            'data' => new TableBookingScheduleResource($data)
        ]);
    }

    public function update(Request $request, $id){ 
        $userId = Auth::user()->id;
        $data = TableBookingSchedule::find($id);
        $data->update(array_merge(
            $request->only([
                'tableFloorPlanId',
                'fullName',
                'email',
                'phone',
                'date',
                'time',
                'status',
                'css',
                'numberOfGuests',
                'notes',
            ], ['userId' => $userId])
        ));
        return response()->json([
            'status' => 1,
            'data' => new TableBookingScheduleResource($data),
            'message' => 'Data is saved successfully.'
        ]);
    }

    public function delete($id){
        $data = TableBookingSchedule::find($id);
        if(!isset($data)){
            return response()->json([
                'message' => 'Table not found, deleted already.',
                'status' => 1,
                'data' => [],
        ]);
        }
        $data->delete();
        return response()->json([
            'message' => 'Table Booking deleted Successfully.',
            'status' => 1,
            'data' => []
        ]);
    }

}
