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
        ->orderBy('course_plans.semester', 'ASC')
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

    public function show($id)
    {
        $cpmk = Course_lo::where('course_los.course_plan_id','=',$id)
        ->select('id AS cpmk_id','code','name')
        ->get();

        $assessment = Course_plan_assessment::where('Course_plan_assessments.course_plan_id','=',$id)
        ->select('id AS assessment_id','percentage','name')
        ->get();

        $nilai = Course_lo_assessment::join('course_los','course_los.id','=','course_lo_assessments.course_lo_id')
        ->where('course_los.course_plan_id','=',$id)
        ->select('course_lo_id', 'course_plan_assessment_id','precentage')
        ->orderBy('course_plan_assessment_id', 'ASC')
        ->get();

        // Ambil Nilai Total Untuk CPMK

        $totalcpmk = array();
        $indeksarr = 0;

        foreach ($cpmk as $cpmktot) {
            $ambiltotal = Course_lo_assessment::join('course_los','course_los.id','=','course_lo_assessments.course_lo_id')
            ->where('course_los.id','=' , $cpmktot->cpmk_id) 
            ->select('precentage')
            ->get();

            $totalasli = 0;

            foreach ($ambiltotal as $jumlahtota) {
                $totalasli = $totalasli + $jumlahtota->precentage;
            }

            $totalcpmk[$indeksarr] = $totalasli;
            $indeksarr++;

        }

        // Ambil Nilai Total Untuk Assessment
        $totalAsses = array();
        $indeksAssess = 0;
        $totalAkhir = 0;

        foreach ($assessment as $assessitem) {
            $ambilJumlahAssess = Course_lo_assessment::join('course_plan_assessments','course_plan_assessments.id','=','course_lo_assessments.course_plan_assessment_id')
            ->where('course_plan_assessments.id','=' , $assessitem->assessment_id) 
            ->select('precentage')
            ->get();

            $penjumlahan = 0;

            foreach ($ambilJumlahAssess as $jumlahAssess) {
                $penjumlahan = $penjumlahan+$jumlahAssess->precentage;
            }

            $totalAsses[$indeksAssess] = $penjumlahan;
            $totalAkhir = $totalAkhir+$totalAsses[$indeksAssess];
            $indeksAssess++;
        }
        $totalAsses[$indeksAssess]=$totalAkhir;



        $namamMtkul =  Course_plan::join('courses','courses.id', '=', 'course_plans.course_id')
        ->where('course_plans.id','=', $id)
        ->select('courses.name')
        ->get();

        
        $parameter = Course_lo_assessment::join('course_los','course_los.id','=','course_lo_assessments.course_lo_id')
        ->where('course_los.course_plan_id','=',$id)
        ->select('course_lo_id', 'course_plan_assessment_id','precentage')
        ->orderBy('course_plan_assessment_id', 'ASC')
        ->first();

        if (!$parameter) {
            foreach ($cpmk as $paramcpmk) {
                foreach ($assessment as $paramass) {
                    $data = course_lo_assessment::create([
                        'course_lo_id' => $paramcpmk->cpmk_id,
                        'course_plan_assessment_id' => $paramass->assessment_id,
                        'precentage' => 0,
                    ]);
                }
                
            }
        }
        
        return response()->json([
            [
                'matkul' => $namamMtkul,
                'cpmk' => $cpmk,
                'assessment' => $assessment,
                'nilai' => $nilai,
                'totalcpmk' => $totalcpmk,
                'totalAsses' => $totalAsses,
            ],
            
        ]);
    }

    public function edit(Request $request)
    {
        $update= Course_lo_assessment::where('course_plan_assessment_id',$request->assessment_id)
        ->where('course_lo_id', $request->cpmk_id)
        ->update([
            'precentage' => $request->nilai
         ]);

      
            return response()->json([
                'cpmk_id' => $request->cpmk_id,
                'assessment_id' => $request->assessment_id,
                'nilai' => $request->nilai,
            ]);
         
    }


}
