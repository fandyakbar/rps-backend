<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\course_plan;

use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course;
use App\model\course_plan_lecturer;

class MyrpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Course_plan::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $namamMtkul =  Course_plan::join('courses','courses.id', '=', 'course_plans.course_id')
        ->where('course_plans.id','=', $id)
        ->select('courses.name', 'courses.semester', 'courses.credit')
        ->get();

        $cpmk = Course_lo::where('course_los.course_plan_id','=',$id)
        ->select('id AS cpmk_id','code','name')
        ->get();

        $assessment = Course_plan_assessment::where('Course_plan_assessments.course_plan_id','=',$id)
        ->select('id AS assessment_id','percentage','name')
        ->get();

        return response()->json([
            [
                'matkul' => $namamMtkul,
                'cpmk' => $cpmk,
                'assessment' => $assessment,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
