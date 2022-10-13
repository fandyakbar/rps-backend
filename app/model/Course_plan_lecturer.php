<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_lecturer extends Model
{
    //
    protected $table = 'course_plan_lecturers';

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }

    public function course_plan()
    {
        return $this->belongsTo(course_plan::class, 'course_plan_id', 'id');
    }
}
