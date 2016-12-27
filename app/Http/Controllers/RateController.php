<?php

namespace App\Http\Controllers;

use App\Rate;
use App\Course;
use App\Teacher;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * CourseTableController constructor.
     */
    public function __construct()
    {
        $this->middleware('owner:rate', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO
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
        $this->validate($request, [
            'rateable_type' => 'required',
            'rateable_id'   => 'required',
            'star'          => 'required|integer|between:1,5',
            'comment'       => 'max:65535',
        ]);
        $rateableType = $request->get('rateable_type');
        $rateableId = $request->get('rateable_id');
        /* @var Course|Teacher $rateable */
        $rateable = $rateableType::find($rateableId);
        if (!$rateable) {
            return redirect()->back()->with('warning', '發生錯誤');
        }
        $user = auth()->user();
        $rateable->rates()->save(new Rate([
            'user_id' => $user->id,
            'star'    => $request->get('star'),
            'comment' => $request->get('comment'),
        ]));

        return redirect()->back()->with('global', '已新增評價');
    }

    /**
     * Display the specified resource.
     *
     * @param Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        $this->validate($request, [
            'star'    => 'required|integer|between:1,5',
            'comment' => 'max:65535',
        ]);
        $rate->update([
            'star'    => $request->get('star'),
            'comment' => $request->get('comment'),
        ]);

        return redirect()->back()->with('global', '已更新評價');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rate $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //TODO
    }
}
