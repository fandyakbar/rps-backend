<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_detail_assessment extends Model
{
    //
    protected $table = 'course_plan_detail_assessments';

   
    public function course_plan_detail()
    {
        return $this->belongsTo(Course_plan_detail::class, 'course_plan_detail_id', 'id');
    }

  
    public function course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }
}
