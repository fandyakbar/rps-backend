<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course_plan;
use App\model\course;
use App\model\course_plan_lecturer;

class CPMKController extends Controller
{
    //
    public function get($id)
    {
        $namamMtkul =  Course_plan::join('courses','courses.id', '=', 'course_plans.course_id')
        ->where('course_plans.id','=', $id)
        ->select('courses.name')
        ->get();

        $data=Course_plan::join('course_los','course_los.course_plan_id', '=', 'course_plans.id')
        ->where('course_plans.id','=', $id)
        ->get();

        return response()->json([
            [
                'matkul' => $namamMtkul,
                'datas' => $data,
            ],
        ]);
    }

    public function create(Request $request, $id)
    {
        $data = course_lo::create([
            'course_plan_id' => $id,
            'name' => request('name'),
            'code' => request('code'),
        ]);

        if ($data) {
            return response()->json([
                'message' => 'success tambah cpmk'
            ]);
        } else {
            return response()->json([
                'message' => 'cpmk tidak berhasil ditambahkan'
            ]);
        }


        
    }
}
