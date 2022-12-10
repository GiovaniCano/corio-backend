<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveListRequest;
use App\Models\Itemable;
use App\Models\Listt;
use Illuminate\Support\Facades\DB;

class ListtController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Listt::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $lists = Listt::where('user_id', auth()->user()->id)->orderBy('name')->get();

        $lists->each(function(Listt $list) {
            $items = $list->items;

            $list->setRelation('items', 
                $items->groupBy('id')
                      ->sortBy(fn($item) => $item[0]->name)
                      ->values()
                      ->map(fn($item) => $item->count() > 1 ? $item : $item[0])
            );
    
            return $list;
        });

        return $lists;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveListRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated) {
            $list = Listt::create([
                'name' => $validated['name'],
                'user_id' => auth()->id()
            ]);

            foreach ($validated['items'] as $item) {
                $itemable = Itemable::create([
                    'itemable_type' => $list::class,
                    'itemable_id' => $list->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'measurement_unit_id' => $item['measurement_unit_id'],
                ]);
                $itemable->trail()->create(['trail' => $item['trail']]);
            }
        });

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function show(Listt $listt)
    {
        return $listt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveListRequest  $request
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function update(SaveListRequest $request, Listt $listt)
    {
        $validated = $request->validated();
        
        DB::transaction(function() use ($validated, $listt) {
            $listt->update(['name' => $validated['name']]);
            $listt->items()->detach();

            foreach ($validated['items'] as $item) {
                $itemable = Itemable::create([
                    'itemable_type' => $listt::class,
                    'itemable_id' => $listt->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'measurement_unit_id' => $item['measurement_unit_id'],
                ]);
                $itemable->trail()->create(['trail' => $item['trail']]);
            }
        });
        
        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listt $listt)
    {
        DB::transaction(function() use ($listt) {
            $listt->items()->detach();
            $listt->delete();
        });
        return response(null, 204);
    }
}
