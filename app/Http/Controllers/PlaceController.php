<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Venue;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePlaceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlaceRequest $request, Venue $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $place)
    {
        //
    }
}
