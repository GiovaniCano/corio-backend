<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDayRequest;
use App\Models\Day;
use App\Models\DaySection;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Day::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Day::where('user_id', auth()->user()->id)->orderBy('name')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveDayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveDayRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function() use($validated) {
            $day = Day::create([
                'name' => $validated['name'],
                'user_id' => auth()->id()
            ]);

            foreach ($validated['sections'] as $section) {
                $day_section = DaySection::create([
                    'name' => $section['name'],
                    'user_id' => auth()->id(),
                    'day_id' => $day->id
                ]);
                $day_section->dishes()->sync($section['dishes']);
                $day_section->syncValidatedItems($section['items']);
            }
        });

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Day  $day
     * @return \Illuminate\Http\Response
     */
    public function show(Day $day)
    {
        return $day;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveDayRequest  $request
     * @param  \App\Models\Day  $day
     * @return \Illuminate\Http\Response
     */
    public function update(SaveDayRequest $request, Day $day)
    {
        $validated = $request->validated();

        DB::transaction(function() use($validated, $day) {
            $day->update(['name' => $validated['name']]);

            $day->daySections->each(fn($section) => $section->items()->detach());
            $day->daySections()->delete();

            foreach ($validated['sections'] as $section) {
                $day_section = DaySection::create([
                    'name' => $section['name'],
                    'user_id' => auth()->id(),
                    'day_id' => $day->id
                ]);
                $day_section->dishes()->sync($section['dishes']);
                $day_section->syncValidatedItems($section['items']);
            }
        });

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Day  $day
     * @return \Illuminate\Http\Response
     */
    public function destroy(Day $day)
    {
        DB::transaction(function() use($day) {
            $day->daySections->each(fn($section) => $section->items()->detach());
            $day->delete();
        }, 2);
        return response(null, 204);
    }
}
