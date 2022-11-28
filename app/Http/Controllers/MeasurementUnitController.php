<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use Illuminate\Http\Request;

class MeasurementUnitController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(MeasurementUnit::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $public_units = MeasurementUnit::whereIn('id', [1,2,3,4,5])->get();
        $user_units = MeasurementUnit::where('user_id', auth()->user()->id)->get();
        return $public_units->merge($user_units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function show(MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeasurementUnit $measurementUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeasurementUnit $measurementUnit)
    {
        //
    }
}
