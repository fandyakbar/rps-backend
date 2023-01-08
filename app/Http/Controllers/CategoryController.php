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
use App\model\Assessment_category;
use App\model\Assessment_category_detail;
use App\model\Detail_category;

class CategoryController extends Controller
{
    //
    public function get($id)
    {
        $ambildata = assessment_category_detail::where('course_plan_assessment_id','=', $id)
        ->join('assessment_categories','assessment_categories.id', '=', 'assessment_category_details.assessment_category_id')
        ->select('assessment_categories.name as kategori','assessment_categories.id as idkat')
        ->orderBy('idkat','ASC')
        ->get();
        
        $ambildatas = assessment_category_detail::where('course_plan_assessment_id','=', $id)->first();

        $ambilsemuaKategori = assessment_category::get();

        $ambilrubrik = Detail_category::join('assessment_details','assessment_details.id','=','detail_categories.assessment_detail_id')
        ->where('assessment_details.course_plan_assessment_id','=', $id)
        ->select('detail_categories.assessment_category_id','detail_categories.assessment_detail_id','detail_categories.value','detail_categories.point')
        ->orderBy('detail_categories.assessment_category_id', 'ASC')
        ->get();

        return response()->json([
            [

                'data' => $ambildata,
                'dataKategori' => $ambilsemuaKategori,
                'rubrik' => $ambilrubrik,
                
            ],
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = assessment_category_detail::create([
            'course_plan_assessment_id' => $id,
            'assessment_category_id' => request('kategori_id'),
        ]);

        $detailAssess = Assessment_detail::where('course_plan_assessment_id','=',$id)
        ->get();

        if ($detailAssess) {
            foreach ($detailAssess as $creates) {
                $detailKategori = detail_category::create([
                    'assessment_detail_id' => $creates->id,
                    'assessment_category_id' => request('kategori_id'),
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

    public function adds(Request $request)
    {
        $data = assessment_category::create([
            'name' => $request->name,
        ]);

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

    public function delete($idkategori, $idAssessment)
    {
        $hapus = assessment_category_detail::where('assessment_category_id', $idkategori)
        ->where('course_plan_assessment_id', $idAssessment)
        ->delete();

        $getDelete  = detail_category::where('assessment_category_id', $idkategori)
        ->get();

        if ($getDelete) {
            $delete = detail_category::where('assessment_category_id', $idkategori)
            ->delete();
        }

        if ($hapus) {
            return "Data Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }

    public function updateRubrik(Request $request)
    {
        if ($request->nilai != null && $request->point != null) {
            $update= detail_category::where('assessment_detail_id',$request->id_kriteria)
            ->where('assessment_category_id', $request->id_kategori)
            ->update([
                'value' => $request->nilai,
                'point' => $request->point,
                    ]);
        } elseif ($request->nilai != null) {
            $update= detail_category::where('assessment_detail_id',$request->id_kriteria)
            ->where('assessment_category_id', $request->id_kategori)
            ->update([
                'value' => $request->nilai,
                    ]);

        } elseif ($request->point != null) {

            $update= detail_category::where('assessment_detail_id',$request->id_kriteria)
            ->where('assessment_category_id', $request->id_kategori)
            ->update([
                'point' => $request->point,
                    ]);
            
        }

        if ($update) {
            return response()->json([
                'message' => 'Berhasil Update',
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal Update',
            ]);
        }
        
    }
}
