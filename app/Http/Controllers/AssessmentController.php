<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course_plan;
use App\model\course;
use App\model\course_plan_lecturer;

class AssessmentController extends Controller
{
    //
    public function get($id)
    {
        $namamMtkul =  Course_plan::join('courses','courses.id', '=', 'course_plans.course_id')
        ->where('course_plans.id','=', $id)
        ->select('courses.name')
        ->get();

        $data=Course_plan_assessment::where('course_plan_assessments.course_plan_id','=', $id)
        ->get();

        $total =0;

        foreach ($data as $jumlahases) {
            $total =$total + $jumlahases->percentage;
        }


        $assessment = Course_plan_assessment::where('Course_plan_assessments.course_plan_id','=',$id)
        ->select('id AS assessment_id','percentage','name')
        ->get();

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
         $total = $totalAkhir;

        return response()->json([
            [
                'matkul' => $namamMtkul,
                'datas' => $data,
                'total' => $total,
                'totalAsses' => $totalAsses,
            ],
        ]);
    }

    public function create(Request $request, $id)
    {
        $data = course_plan_assessment::create([
            'course_plan_id' => $id,
            'name' => request('name'),
            'percentage' => request('percentage'),
        ]);

        $cpmk = course_lo::where('course_plan_id','=', $id)->get();

        $cekdetail = course_lo_assessment::join('course_plan_assessments','course_plan_assessments.id','=', 'course_lo_assessments.course_plan_assessment_id')
        ->where('course_lo_assessments.course_plan_assessment_id','=', $data->id)
        ->first();

        if (!$cekdetail) {
            foreach ($cpmk as $cpmkm) {
                $datalo = course_lo_assessment::create([
                    'course_lo_id' => $cpmkm->id,
                    'course_plan_assessment_id' => $data->id,
                    'precentage' => 0,
                ]);
            }
        }

        if ($data) {
            return response()->json([
                'message' => 'assessment ditambah'
            ]);
        } else {
            return response()->json([
                'message' => 'gagal menambah assessment'
            ]);
        }


        
    }
    public function delete($id)
    {
        $parameter = course_lo_assessment::where('course_plan_assessment_id','=', $id)->get();

        if ($parameter) {
            $musnah = course_lo_assessment::where('course_plan_assessment_id','=', $id)->delete();
        }
        
        $hapus = Course_plan_assessment::where('id', $id)
        ->delete();

        if ($hapus) {
            return "Data Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }

    public function show($id){
        $ambilData = course_plan_assessment::join('course_plans','course_plans.id','=','course_plan_assessments.course_plan_id')
        ->where('course_plan_assessments.id','=',$id)
        ->select('course_plan_assessments.name as name', 'percentage', 'course_plan_id')
        ->first();

        return $ambilData;
    }

    public function update(Request $request, $id){

        $update= Course_plan_assessment::where('id',$id)
        ->update([
            'name' => $request->penilaian,
            'percentage' => $request->presentase,
         ]);

         if ($update) {
            return response()->json([
                'message' => 'Sukses Update Data'
            ]);
         }
    }

}
