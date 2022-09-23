<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course_plan;
use App\model\course;
use App\model\course_plan_lecturer;

class RPSController extends Controller
{
    //
    public function list()
    {

        $data=Course_plan::get();
        $datas=Course_plan::get();

        $parameter = array();
        $indeks = 0;

        
        foreach ($data as $params) {
            $jumlah = 0;
            foreach ($params->course_lo as $checker) {
                foreach ($checker->course_lo_assessment as $paramcheck) {
                    $jumlah = $jumlah + $paramcheck->precentage;
                }
            }
                $parameter[$indeks] = $jumlah;
                $indeks++;
        }
        return response()->json([
            [
                'rps' => $datas,
                'checker' => $parameter
            ],
        ]);
    }

    public function get($id)
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
}
