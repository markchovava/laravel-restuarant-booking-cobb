<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    
    
    public function indexAll(){
         $data = Contact::orderBy('updated_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();
        return ContactResource::collection($data);
    }

    public function index(){
        $data = Contact::orderBy('updated_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->paginate(20);
        return ContactResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = Contact::where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('name', 'ASC')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20);
            return ContactResource::collection($data);
        }
        return $this->index();
    }

    public function view($id){
        $data = Contact::find($id);
        return new ContactResource($data);
    }
    
    public function store(Request $request){
        Log::info($request);
        $data = Contact::create(array_merge(
            $request->only([
                'name', 
                'message', 
                'email',  
                'status',
            ]),
        ));
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully saved.',
            'data' => new ContactResource($data),
        ]);
    }

    public function update(Request $request, $id){
        $ContactId = Auth::user()->id;
        $data = Contact::findOrFail($id);
        $data->update($request->only([
            'status',
            'name', 
            'message', 
            'email',  
        ], 
        ['ContactId' => $ContactId]));
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully updated.',
            'data' => new ContactResource($data),
        ]);
    }

    public function delete($id){
        $data = Contact::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted updated.',
            'data' => new ContactResource($data),
        ]);
    }


}
