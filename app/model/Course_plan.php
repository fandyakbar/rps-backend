<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan extends Model
{
    //
    protected $table = 'course_plans';
  
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

   
    public function course_lo()
    {
        return $this->hasMany(Course_lo::class, 'course_plan_id', 'id');
    }

   
    public function course_plan_lecturer()
    {
        return $this->hasMany(Course_plan_lecturer::class, 'course_plan_id', 'id');
    }

   
    public function course_plan_assessment()
    {
        return $this->hasMany(Course_plan_assessment::class, 'course_plan_id', 'id');
    }

    
    public function course_plan_detail()
    {
        return $this->hasMany(Course_plan_detail::class, 'course_plan_id', 'id');
    }

    
    public function Course_plan_task()
    {
        return $this->hasMany(Course_plan_task::class, 'course_plan_id', 'id');
    }
}
