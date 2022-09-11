<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_detail_outcome extends Model
{
    //
    protected $table = 'course_plan_detail_outcome';

    public function course_lo()
    {
        return $this->belongsTo(Course_lo::class, 'course_lo_id', 'id');
    }

    public function course_plan_detail()
    {
        return $this->belongsTo(course_plan_detail::class, 'course_plan_detail_id', 'id');
    }
    

}
