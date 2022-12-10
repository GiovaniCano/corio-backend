<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Item::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::where('user_id', auth()->user()->id)->orderBy('name')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveItemRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $item = Item::create($validated);

        return response($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(SaveItemRequest $request, Item $item)
    {
        $validated = $request->validated();
        $item->update($validated);
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response(null, 204);
    }
}
