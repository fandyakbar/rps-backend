<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_detail extends Model
{
    //
    protected $table = 'course_plan_details';

    public function course_plan()
    {
        return $this->belongsTo(course_plan::class, 'course_plan_id', 'id');
    }

    /**
     * Get all of the comments for the Course_plan_detail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_detail_outcome()
    {
        return $this->hasMany(Course_plan_detail_outcome::class, 'course_plan_detail_id', 'id');
    }

    public function course_plan_detail_assessment()
    {
        return $this->hasMany(Course_plan_detail_assessment::class, 'course_plan_detail_id', 'id');
    }

    


}
