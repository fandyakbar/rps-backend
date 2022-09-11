<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lecturers';
    public function course_plan_lecturer()
    {
        return $this->hasMany(Course_plan_lecturer::class, 'lecturer_id', 'id');
    }
}
