<?php

namespace App\Http\Controllers\Meet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class MeetController extends Controller
{
    //create Meet;
    function createMeet(Request $request)
    {
        $meet = new Meeting;
        $meet->sender_id =  Auth::id();
        $meet->receiver_id = $request->receiver_id;
        $meet->link_url = $request->link_url;
        $meet->date = $request->date;
        $meet->save();

        return response()->json([
            'status' => 'success',
            'data' => $meet
        ]);
    }

    //get meets if any exist
    function checkMeet()
    {
        $user = Auth::user();
        $meet = Meeting::all()->where('receiver_id', $user->id);

        return response()->json([
            'status' => 'success',
            'data' => $meet
        ]);
    }

    //delete meet
    function removeMeet($id)
    {
        $user = Auth::user();
        if ($user->user_type_id == 2) {
            $meet = Meeting::where('receiver_id', $user->id)->delete();
        }
        if ($user->user_type_id == 3) {
            $meet = Meeting::find($id)->where('sender_id', $user->id)->delete();
        }else {
            return response()->json([
            'status' => 'faild',
        ]);
        }
    }
}
