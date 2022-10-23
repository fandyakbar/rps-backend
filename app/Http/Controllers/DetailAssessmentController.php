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
use App\model\Assessment_category_detail;
use App\model\Detail_category;


class DetailAssessmentController extends Controller
{
    //
    public function index($id)
    {
        $namaAssessment = course_plan_assessment::where('course_plan_id','=',$id)
        ->select('course_plan_assessments.name','course_plan_assessments.id','course_plan_assessments.flag')
        ->get();

        $getCPMK = array();
        $getRubrik = array();
        $getDataCPMK = array();
       
        $indeksGetCPMK = 0;

        foreach ($namaAssessment as $assessment) {
           
            $getCPMK[$indeksGetCPMK] = course_lo_assessment::where('course_plan_assessment_id','=', $assessment->id)
            ->join('course_los','course_los.id','=', 'course_lo_assessments.course_lo_id')
            ->select('course_los.code','course_los.name','course_los.id as cpmk_id')
            ->where('course_lo_assessments.precentage' ,'!=', 0)
            ->get();

            $getRubrik[$indeksGetCPMK] =assessment_detail::where('course_plan_assessment_id','=', $assessment->id)
            ->get();

            $getNilaiRub = array();
            $indeksgr= 0;
            foreach ($getRubrik[$indeksGetCPMK] as $gr) {
                $getNilaiRub[$indeksgr] = $gr -> detail_category;
                $indeksgr++;
            }
            

            $getDataCPMK[$indeksGetCPMK]= assessment_detail_lo::join('assessment_details','assessment_details.id','=', 'assessment_detail_los.assessment_detail_id')
            ->where('assessment_details.course_plan_assessment_id','=', $assessment->id)
            ->join('course_los','course_los.id','=','assessment_detail_los.course_lo_id')
            ->select('course_los.code', 'assessment_details.id')
            ->get();

            $indeksGetCPMK++;
    
        }

        $cpa = Course_plan_assessment::where('course_plan_id','=', $id)->get();
        $header = array();
        $headerPrint = array();
        $indeksh = 0;
        
        foreach ($cpa as $cp) {
            $indekshp = 0;
            $header[$indeksh] = $cp->assessment_category_detail;
            foreach ($cp->assessment_category_detail as $getName) {
                $headerPrint[$indekshp] = $getName->assessment_category->name;
                $indekshp++;
            }
            $indeksh++;
        }


        return response()->json([
            [
                'assessment' => $namaAssessment,
                'cpmk' =>$getCPMK,
                'datas' => $getRubrik,
                'cpmkcode' => $getDataCPMK,
                'header' => $header,
                'headerPrint' => $headerPrint,
            ],
        ]);

    }
    public function get($id)
    {
        $namaAssessment = course_plan_assessment::where('id', '=', $id)
        ->get();

        
        
        $cpmkAssess = course_lo_assessment::where('course_plan_assessment_id','=', $id)
        ->join('course_los','course_los.id','=', 'course_lo_assessments.course_lo_id')
        ->select('course_los.code','course_los.name','course_los.id as cpmk_id')
        ->where('course_lo_assessments.precentage' ,'!=', 0)
        ->get();

        // Ambil data nama
        
        $namaAssessments = course_plan_assessment::where('id', '=', $id)
        ->first();

        $kodeMatkul = $namaAssessments->course_plan->course->code;
        $namaMatkul = $namaAssessments->course_plan->course->name;

        // Ambil data

        $data = assessment_detail::where('course_plan_assessment_id','=', $id)
        ->get();

        $datacpmk = assessment_detail_lo::join('assessment_details','assessment_details.id','=', 'assessment_detail_los.assessment_detail_id')
        ->where('assessment_details.course_plan_assessment_id','=', $id)
        ->join('course_los','course_los.id','=','assessment_detail_los.course_lo_id')
        ->select('course_los.code', 'assessment_details.id')
        ->get();

        // mengelompokkan

        $kodecpmk = array();
        $indeks = 0;

        


        return response()->json([
            [
                'assessment' => $namaAssessments->name,
                'matkul' => $namaMatkul,
                'kodematkul' => $kodeMatkul,
                'cpmk' => $cpmkAssess,
                'datas' => $data,
                'cpmkcode' => $datacpmk,

            ],
        ]);
    }

    public function create (Request $request, $id)
    {
        $this->validate($request, Assessment_detail::$validasi_tambah);

        $data = Assessment_detail::create([
            'course_plan_assessment_id' => $id,
            'criteria' => request('criteria'),
            
        ]);


        foreach ($request->listcpmk as $cpmkid) {
            $createCPMK = Assessment_detail_lo::create([
                'assessment_detail_id' => $data->id,
                'course_lo_id' => $cpmkid,
            ]);
        }

        $ambilDetail = Assessment_category_detail::where('course_plan_assessment_id','=', $id)
        ->get();

        foreach ($ambilDetail as $param) {
            $createNew = detail_category::create([
                'assessment_detail_id' => $data->id,
                'assessment_category_id' => $param->assessment_category_id,
            ]);
        }

        

        if ($data) {
            return response()->json([
                'message' => 'Kriteria Berhasl Ditabahkan'
            ]);
        } else {
            return response()->json([
                'message' => 'Kriteria gagal ditambahkan'
            ]);
        }
    }

    public function delete($id)
    {
        $parameter = assessment_detail_lo::where('assessment_detail_id','=', $id)->get();

        if ($parameter) {
            $musnah = assessment_detail_lo::where('assessment_detail_id','=', $id)->delete();
        }

        $parameter2 = detail_category::where('assessment_detail_id','=', $id)->get();

        if ($parameter2) {
            $musnah2 = detail_category::where('assessment_detail_id','=', $id)->delete();
        }
        
        $hapus = assessment_detail::where('id', $id)
        ->delete();

        if ($hapus) {
            return "Data Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }

    public function show($id)
    {
        $ambildata = assessment_detail::where('id','=', $id)->first();

        return $ambildata;
    }


    public function shows($id)
    {
        $params = Assessment_detail_lo::where('assessment_detail_id','=', $id)->get();
        $idcpmknya = array();
        $indeksId = 0;

        $string="";

        foreach ($params as $ambilId) {
            $idcpmknya[$indeksId] = $ambilId->course_lo_id;
            $indeksId++; 
        }

      
        return $idcpmknya;
    }

    public function update (Request $request, $id)
    {
        $update = assessment_detail::where('id', '=', $id)
        ->update([
            'criteria' => $request->criteria,
        ]);
        
        $ambillistnya = Assessment_detail_lo::where('assessment_detail_id','=', $id)
        ->delete();
        
        foreach ($request->listcpmk as $cpmkid) {
            $createCPMK = Assessment_detail_lo::create([
                'assessment_detail_id' => $id,
                'course_lo_id' => $cpmkid,
            ]);
        }
        

        if ($update) {
            return response()->json([
                'message' => 'Sukses Update Data'
            ]);
         }
    }

    public function getCPMK($id)
    {
        $ambildata = assessment_detail_lo::where('assessment_detail_id','=', $id)
        ->join('course_los','course_los.id', '=', 'assessment_detail_los.course_lo_id')
        -> select('assessment_detail_los.assessment_detail_id','course_los.id','course_los.code','course_los.name','course_los.id AS cpmk_id')
        ->get();
        
        $ambildatas = assessment_detail_lo::where('assessment_detail_id','=', $id)->first();

        $ambildatass = assessment_detail::where('id','=', $id)->first();

        $idassessment = $ambildatass->course_plan_assessment_id;
        
        $datacpmk = course_lo_assessment::where('course_plan_assessment_id','=', $idassessment)
        ->join('course_los','course_los.id','=', 'course_lo_assessments.course_lo_id')
        ->select('course_los.code','course_los.name','course_los.id AS cpmk_id')
        ->where('course_lo_assessments.precentage' ,'!=', 0)
        ->get();

        return response()->json([
            [

                'data' => $ambildata,
                'cpmk' => $datacpmk,
            ],
        ]);
    }

    public function addCPMK(Request $request, $id)
    {
        $data = Assessment_detail_lo::create([
            'assessment_detail_id' => $id,
            'course_lo_id' => request('cpmk_id'),
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

    public function deleteCPMK($idcpmk, $idDetail)
    {
        $hapus = assessment_detail_lo::where('course_lo_id', $idcpmk)
        ->where('assessment_detail_id', $idDetail)
        ->delete();

        if ($hapus) {
            return "Data Dihapus";
        } else{
            return "Gagal Menghapus Data";
        }
    }
}
