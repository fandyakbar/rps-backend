<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Curriculum_lo extends Model
{
    //
    protected $table = 'curriculum_los';

    public function course_lo_detail()
    {
        return $this->hasMany(Course_lo_detail::class, 'curriculum_lo_id', 'id');
    }
}
