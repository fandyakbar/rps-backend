<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_assessment extends Model
{
    //
    protected $table = 'course_plan_assessments';

    protected $fillable = [
        'course_plan_id',
        'name',
        'percentage',
      ];
    

    public function course_plan()
    {
        return $this->belongsTo(Course_plan::class, 'course_plan_id', 'id');
    }

    /**
     * Get all of the comments for the Course_plan_assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_detail_assesment()
    {
        return $this->hasMany(Course_plan_detail_assesment::class, 'course_plan_assessment_id', 'id');
    }
    
    public function course_lo_assessment()
    {
        return $this->hasMany(Course_lo_assessment::class, 'course_plan_assessment_id', 'id');
    }
}
