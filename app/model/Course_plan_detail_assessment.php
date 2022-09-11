<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_detail_assessment extends Model
{
    //
    protected $table = 'course_plan_detail_assessments';

    /**
     * Get the user that owns the Course_plan_detail_assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course_plan_detail()
    {
        return $this->belongsTo(Course_plan_detail::class, 'course_plan_detail_id', 'id');
    }

    /**
     * Get all of the course_plan_assessment for the Course_plan_detail_assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }
}
