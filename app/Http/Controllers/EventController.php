<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Traits\AttachmentsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use AttachmentsTrait;

     /**
     * Apply auth middleware
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($start,$end,$type)
    {
        if($type == 'day') {
            $start = Carbon::parse($start)->startOfMonth();
            $end = Carbon::parse($end)->endOfMonth();
        }

        $events = Event::with(['project','attachments' => function ($query) {
                $query->where(['reference_table' => 'events']);
                }])->where([['start_date','>=',$start],['end_date' ,'<=', $end]])->get();
        
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     * note: shorthand conditions are string because FormData() treat post data as string unless JSON.stringified
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $attributes['created_by']       = auth()->id();
        $attributes['description']      = $request->description;
        $attributes['title']            = $request->title;        
        $attributes['project_id']       = $request->project_id;
        $attributes['start_date']       = $request->start_date;
        $attributes['start_time']       = $request->start_time == 'null' ? NULL : $request->start_time;
        $attributes['end_date']         = $request->end_date;
        $attributes['end_time']         = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['color']            = $request->color;
        $attributes['all_day']          = $request->all_day == 'true' ? 1 : 0;

        $event = Event::create($attributes);

        // multiple attachments
        if($event) {
            if($request->hasFile('attachments')) {
                $this->storeAttachment('events',$event->id,$request->file('attachments'));
            }
        }

        // notifications table


        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * note: shorthand conditions are string because FormData() treat post data as string unless JSON.stringified
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {        
        $attributes['all_day']    = $request->all_day == 'true' ? 1 : 0;
        $attributes['color']      = $request->color;                
        $attributes['description']= $request->description; 
        $attributes['end_date']   = $request->end_date;
        $attributes['end_time']   = $request->end_time == 'null' ? NULL : $request->end_time;
        $attributes['project_id'] = $request->project_id;
        $attributes['start_date'] = $request->start_date;
        $attributes['start_time'] = $request->start_time == 'null' ? NULL : $request->start_time;
        $attributes['title']      = $request->title;
        $attributes['updated_by'] = auth()->id();

        $result = $event->update($attributes);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $result = $event->delete();
        return response()->json($result);
    }

    /**
     * cancel an event
     */
    public function cancel(Event $event)
    {
        $attributes['title'] = "(cancelled) ".$event->title;
        $attributes['updated_by'] = auth()->id();
        $attributes['is_cancelled'] = 1;

        $result = $event->update($attributes);
        return response()->json($result);
    }
}
