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

        $asses = course_plan_assessment::where('course_plan_id','=', $id)->get();

        $cekdetail = course_lo_assessment::join('course_los','course_los.id','=', 'course_lo_assessments.course_lo_id')
        ->where('course_lo_assessments.course_lo_id','=', $data->id)
        ->first();

        if (!$cekdetail) {
            foreach ($asses as $penilaian) {
                $datalo = course_lo_assessment::create([
                    'course_lo_id' => $data->id,
                    'course_plan_assessment_id' => $penilaian->id,
                    'precentage' => 0,
                ]);
            }
        }



        if ($data) {
            return response()->json([
                'message' => 'Berhasil Menambah Data'
            ]);
        } else {
            return response()->json([
                'message' => 'cpmk tidak berhasil ditambahkan'
            ]);
        }


        
    }

    public function delete($id)
    {
        $parameter = course_lo_assessment::where('course_lo_id','=', $id)->get();

        if ($parameter) {
            $musnah = course_lo_assessment::where('course_lo_id','=', $id)->delete();
        }

        $hapus = Course_lo::where('id', $id)
        ->delete();

        if ($hapus) {
            return "Data Berhasil Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }

    public function show($id){
        $ambilData = course_lo::join('course_plans','course_plans.id','=','course_los.course_plan_id')
        ->where('course_los.id','=',$id)
        ->select('course_los.name as name', 'course_los.code', 'course_plan_id')
        ->first();

        return $ambilData;
    }

    public function update(Request $request, $id){

        $update= Course_lo::where('id',$id)
        ->update([
            'name' => $request->nama,
            'code' => $request->kode,
         ]);

         if ($update) {
            return response()->json([
                'message' => 'Sukses Update Data'
            ]);
         }
    }
}
