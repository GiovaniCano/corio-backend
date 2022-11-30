<?php

namespace App\Http\Controllers;

use App\Models\Listt;
use Illuminate\Http\Request;

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

        $lists->each(function (Listt $list) {
            $items = $list->items;

            $list->setRelation('items', 
                $items->groupBy('id')
                    ->sortBy(function($item){
                        return $item[0]->name;
                    })
                    ->values()
                    ->map(function($item){
                        return $item->count() > 1 ? $item : $item[0];
                    })
            );
        });

        return $lists;
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
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function show(Listt $listt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listt $listt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listt  $listt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listt $listt)
    {
        //
    }
}
