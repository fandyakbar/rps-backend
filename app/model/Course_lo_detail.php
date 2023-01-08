<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_lo_detail extends Model
{
    protected $table = 'course_lo_details';


    public function curriculum_lo()
    {
        return $this->belongsTo(Curriculum_lo::class, 'curriculum_lo_id', 'id');
    }

    public function course_lo()
    {
        return $this->belongsTo(Course_lo::class, 'course_lo_id', 'id');
    }
}
