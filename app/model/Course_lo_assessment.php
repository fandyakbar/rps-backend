<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_lo_assessment extends Model
{
    //
    protected $table = 'course_lo_assessments';

    protected $fillable = [
        'course_lo_id',
        'course_plan_assessment_id',
        'precentage',
      ];
    /**
     * Get all of the comments for the Course_lo_assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get the user that owns the Course_lo_assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course_lo()
    {
        return $this->belongsTo(Course_lo::class, 'course_lo_id', 'id');
    }
    
    public function course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }


}
