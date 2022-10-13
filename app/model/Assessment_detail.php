<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Assessment_detail extends Model
{
    //
    protected $table = 'assessment_details';

    protected $fillable = [
        'course_plan_assessment_id',
        'criteria',
        'inferior',
        'average',
        'good',
        'Excellent',
      ];

      static $validasi_tambah = [
        'criteria' => 'required|max:100',
        'inferior' =>'required',
        'average' => 'required',
        'good' => 'required',
        'Excellent' => 'required',
    ];

   
    public function Course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }


    public function Assessment_detail_lo()
    {
        return $this->hasMany(Assessment_detail_lo::class, 'assessment_id', 'id');
    }
}
