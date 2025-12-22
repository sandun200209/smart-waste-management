<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest; 
use App\Models\Request as PickupRequest; 
use App\Models\Route;
use Illuminate\Support\Facades\Http;

class RequestController extends Controller
{
    // Dashboard Chart  Table
    public function dashboard()
    {
        // 1. Chart  Counts (Admin view)
        $pendingCount = PickupRequest::where('status', 'pending')->count();
        $assignedCount = PickupRequest::where('status', 'assigned')->count();
        $completedCount = PickupRequest::where('status', 'completed')->count();

        // 2. Login  User  Requests (Table )
        $requests = PickupRequest::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('dashboard', compact('pendingCount', 'assignedCount', 'completedCount', 'requests'));
    }

    // Request  Form 
    public function create()
    {
        return view('requests.create');
    }

    // Request Database  Save 
    public function store(HttpRequest $request)
    {
        $request->validate([
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        PickupRequest::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('status', 'Request successfully submitted!');
    }

    // Google Maps API  Optimize 
    public function optimizeRoute()
    {
        $requests = PickupRequest::where('status', 'pending')->get();

        if($requests->isEmpty()){
            return "No pending requests.";
        }

        $driverId = 1;
        $origin = '6.9271,79.8612';
        $destination = $origin;

        $waypoints = $requests->map(function($req){
            return $req->latitude . ',' . $req->longitude;
        })->implode('|');

        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&waypoints=optimize:true|$waypoints&key=$apiKey";

        $response = Http::get($url);
        
        if ($response->failed()) {
            return "API Request failed.";
        }

        $data = $response->json();
        $optimizedOrder = $data['routes'][0]['waypoint_order'];

        $optimizedPoints = [];
        foreach($optimizedOrder as $index){
            $req = $requests[$index];
            $optimizedPoints[] = [
                'request_id' => $req->id,
                'lat' => $req->latitude,
                'lng' => $req->longitude
            ];
        }

        $totalDistance = array_reduce($data['routes'][0]['legs'], function($carry, $leg){
            return $carry + $leg['distance']['value'];
        }, 0) / 1000;

        Route::create([
            'driver_id' => $driverId,
            'route_points' => $optimizedPoints, 
            'total_distance' => $totalDistance,
        ]);

        foreach($requests as $req) {
            $req->update(['status' => 'assigned']);
        }

        return redirect()->route('dashboard')->with('status', "Route Optimized! Distance: " . round($totalDistance, 2) . " KM");
    }

    // Driver Map show
    public function showRoute($id)
    {
        $route = Route::findOrFail($id);
        return view('driver.route', compact('route'));
    }
}