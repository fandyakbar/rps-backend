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
       
    ];

   
    public function course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }


    public function assessment_detail_lo()
    {
        return $this->hasMany(Assessment_detail_lo::class, 'assessment_detail_id', 'id');
    }

   
    public function detail_category()
    {
        return $this->hasMany(Detail_category::class, 'assessment_detail_id', 'id');
    }
}
