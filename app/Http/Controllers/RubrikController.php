<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course_plan;
use App\model\course;
use App\model\course_plan_lecturer;

class RubrikController extends Controller
{
    //
    public function index()
    {
        $data=Course_lo_assessment::join('course_los','course_los.id','=','course_lo_assessments.course_lo_id')
        ->join('course_plan_assessments','course_plan_assessments.id','=','course_lo_assessments.course_plan_assessment_id')
        -> select('course_los.name AS CPMK','course_plan_assessments.name AS Penilaian', 'course_lo_assessments.precentage', 'course_lo_assessments.course_lo_id AS id_cpmk')
        ->orderBy('course_los.id', 'ASC')
        ->orderBy('course_plan_assessments.id', 'ASC')
        ->get();
        
        return $data;
    }

    public function penilaian()
    {
        $data=Course_plan_assessment::select('name')->get();
        
        return $data;
    }

    public function cpmk()
    {
        $data=Course_lo::select('id','name','precentages')->get();
        
        return $data;
    }
    
    public function list()
    {
        $datauser = auth()->user();
        $id_user = $datauser->id;


        $data=Course_plan::join('courses','courses.id','=','course_plans.course_id')
        ->join('course_plan_lecturers','course_plan_lecturers.course_plan_id', '=', 'course_plans.id')
        ->where('course_plan_lecturers.lecturer_id','=', $id_user)
        ->get();
        
        return $data;
    }

    public function get($id)
    {
        $data=Course_plan::join('course_plan_assessments','course_plan_assessments.course_plan_id','=','course_plans.id')
        ->join('course_los','course_los.course_plan_id', '=', 'course_plans.id')
        ->where('course_plans.id','=', $id)
        ->get();

        return $data;
    }


}
