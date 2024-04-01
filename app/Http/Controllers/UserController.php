<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = User::all();
        return response()->json(['data' => $allUsers->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $user = User::with('vehicles')->findOrFail($userId);

        return response()->json(['data' => $user->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Add vehicle o the user.
     */
    public function addVehicle(Request $request, string $userId)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'color' => 'required|string',
            'cubic_m' => 'required|string',
        ]);

        $user = User::findOrFail($userId);
        $vehicle = Vehicle::findOrFail($request->input('vehicle_id'));

        // Get the sizes array from the vehicle
        $sizes = $vehicle->sizes;

        // Find the size object that matches the requested size
        $sizeObject = collect($sizes)->firstWhere('cubic_m', $request->input('cubic_m'));

        if (!$sizeObject) {
            return response()->json(['message' => 'Invalid size'], 400);
        }

        // Calculate the price based on the size's price factor
        $price = $vehicle->base_price * $sizeObject['price_factor'];

        // Ensure that the user has enough balance
        if ($user->vbalance < $price) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        // Deduct the price from the user's vbalance
        $user->vbalance -= $price;
        $user->save();

        // Attach the vehicle to the user with the calculated price
        $user->vehicles()->attach($vehicle->id, [
            'color' => $request->input('color'),
            'cubic_m' => $request->input('cubic_m'),
            'price' => $price,
        ]);

        return response()->json(['message' => 'Vehicle added successfully']);
    }
}
