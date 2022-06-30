<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    //
    function showForm(){
        return view('events-create');
    }

    function  addEvent(Request $request){
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required',
            'event_description' => 'required'
        ]);

        
        if($validator->fails()){
            return response()->json(['status' => 'fail', 'message' => 'All fields are Required']);
        }

        $startDate = $request->event_start_date;
        // return $startDate;
        $start = date_create($startDate);
        $now  = Carbon::now();
        $today =  Carbon::parse($now)->toDateString();
        
        if ($startDate < $today) {
            return response()->json(['status' => 'fail', 'message' => 'start Date is Invalid']);
        }

        $toDate = $request->event_end_date;
        $to = date_create($toDate);

        $dateDiff = date_diff($start, $to);
        
        $diff = $dateDiff->format("%R%a");
        $diffInt = (int)$diff;

        if ($diffInt < 1) {
            return response()->json(['status' => 'fail', 'message' => 'Invalid Event date']);
        }

        $event = new Event();

        $event->event_name = $request->event_name;
        $event->event_start_date = $request->event_start_date;
        $event->event_end_date = $request->event_end_date;
        $event->event_description = $request->event_description;

        $save = $event->save();

        if($save){
            return response()->json(['status' => 'success', 'message' => "Event Was added", 'link' => '/show']);
        }else{
            return response()->json(['status' => 'fail', 'message' => "Something Went Wrong. Refresh the page"]);
        }

    }

    function showEvents(){
        $events = Event::all();
        return view('show-event', ['events' => $events, 'count' => 1]);
    }

    function showFinished(){
        
        $events = Event::where('event_end_date', '<', date("Y-m-d"))->orderBy('event_start_date','ASC')->get();
        return view('show-event',['events'=>$events, 'count'=>1]);
    }

    function showUpcoming(){
        $events = Event::where('event_end_date', '>', date("Y-m-d"))->orderBy('event_start_date','ASC')->get();
        return view('show-event',['events'=>$events, 'count'=>1]);
    }

    function showUpcomingSeven(){
        $today = date("Y-m-d");
        $date = date('Y-m-d', strtotime('+7 days'));
        
        $events = Event::whereBetween('event_end_date',[$today,$date])->orderBy('event_start_date','ASC')->get();
        return view('show-event',['events'=>$events, 'count'=>1]);
    }

    function showFinishedBeforeSeven(){
        $today = date("Y-m-d");
        $date = date('Y-m-d', strtotime('-7 days'));
        
        $events = Event::whereBetween('event_end_date',[$date,$today])->orderBy('event_start_date','ASC')->get();
        return view('show-event',['events'=>$events, 'count'=>1]);
    }

    function deleteEvent($id){
        $delete = Event::where('id','=',$id)->delete();
        if($delete){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }
}
