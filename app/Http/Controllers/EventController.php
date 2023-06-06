<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $data)
    {
  
            if($data->ajax()) {
        
                $data = Event::whereDate('start', '>=', $data->start)
                        ->whereDate('end',   '<=', $data->end)
                        ->get(['id', 'title', 'start', 'end']);
    
                return response()->json($data);
            }
  
        return view('calender');
    }
 
    public function manageEvent(Request $data)
    {
 
        switch ($data->type) {
            case 'add':
                $event = Event::create([
                    'title' => $data->title,
                    'start' => $data->start,
                    'end' => $data->end,
                ]);
    
                return response()->json($event);
                break;
    
            case 'update':
                $event = Event::find($data->id)->update([
                    'title' => $data->title,
                    'start' => $data->start,
                    'end' => $data->end,
                ]);
    
                return response()->json($event);
                break;
    
            case 'delete':
                $event = Event::find($data->id)->delete();
    
                return response()->json($event);
                break;
                
            default:
                
                break;
        }
    }
}
