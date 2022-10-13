<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\model\course_lo_assessment;
use App\model\course_plan_assessment;
use App\model\course_lo;
use App\model\course_plan;
use App\model\course;
use App\model\course_plan_lecturer;
use App\model\Assessment_detail;
use App\model\Assessment_detail_lo;
use App\model\Course_plan_task;

class TaskController extends Controller
{
    //
    public function get($id)
    {
        $RPS = Course_plan::where('id','=', $id)
        -> first();

        $namaMatkul = $RPS->course->name;

        $tugas = Course_plan_task::where('course_plan_id','=',$id)
        ->get();

        return response()->json([
            [
                'namaMatkul' =>  $namaMatkul,
                'tugas' =>  $tugas,
            ],
        ]);
    }

    public function create(Request $request, $id)
    {
        

        $this->validate($request, course_plan_task::$validasi_tambah);

        $data = Course_plan_task::create([
            'course_plan_id' => $id,
            'name' => $request->name,
            'theme' => $request->theme,
            'description' => $request->description,
            'step' => $request->step,
            'output' => $request->output,
            'member' => $request->member,
        ]);

        if ($data) {
            return response()->json([
                'message' => 'Tugas ditambah'
            ]);
        } else {
            return response()->json([
                'message' => 'Tugas gagal ditambahkan'
            ]);
        }
    }

    public function delete($id)
    {
        $hapus = course_plan_task::where('id', $id)
        ->delete();

        if ($hapus) {
            return "Data Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }

    public function show($id)
    {
        $getData = course_plan_task::where('id', $id)
        ->first();

        return $getData;
    }

    public function update(Request $request, $id)
    {
        $updateData = course_plan_task::where('id', $id)
        ->update([
        
            'name' => $request->name,
            'theme' => $request->theme,
            'description' => $request->description,
            'step' => $request->step,
            'output' => $request->output,
            'member' => $request->member,
        ]);

        if ($updateData) {
            return response()->json([
                'message' => 'Tugas diupdate'
            ]);
        } else {
            return response()->json([
                'message' => 'Tugas gagal diupdate'
            ]);
        }
    }
}
