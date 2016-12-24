<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::orderBy('weekday')->orderBy('number')->get();
        $periodTable = [];
        foreach ($periods as $period) {
            $weekday = $period->weekday;
            $number = $period->number;
            $periodTable[$weekday][$number] = $period;
        }

        return view('admin.period.index', compact('periodTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param Period $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Period $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Period $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Period $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //TODO
    }
}
