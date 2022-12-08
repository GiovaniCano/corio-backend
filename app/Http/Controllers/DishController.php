<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDishRequest;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DishController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Dish::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dish::where('user_id', auth()->user()->id)->orderBy('name')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\SaveDishRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveDishRequest $request)
    {
        $validated = $request->validated();

        $dish = Dish::create([
            'name' => $validated['name'],
            'user_id' => $request->user()->id
        ]);

        $dish->syncValidatedItems($validated['items']);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        return $dish;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\SaveDishRequest  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(SaveDishRequest $request, Dish $dish)
    {
        $validated = $request->validated();

        $dish->update( ['name' => $validated['name']] );

        $dish->syncValidatedItems($validated['items']);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        DB::transaction(function() use ($dish) {
            $dish->items()->detach();
            $dish->delete();
        }, 2);
        return response(null, 204);
    }
}
