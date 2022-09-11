<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan extends Model
{
    //
    protected $table = 'course_plans';
    
    /**
     * Get the course that owns the Course_plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * Get all of the course_los for the Course_plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_lo()
    {
        return $this->hasMany(Course_lo::class, 'course_plan_id', 'id');
    }

    /**
     * Get all of the course_plan_lecture for the Course_plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_lecturer()
    {
        return $this->hasMany(Course_plan_lecturer::class, 'course_plan_id', 'id');
    }

    /**
     * Get all of the course_plan_assesment for the Course_plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_assesment()
    {
        return $this->hasMany(Course_plan_assesment::class, 'course_plan_id', 'id');
    }

    
    public function course_plan_detail()
    {
        return $this->hasMany(Course_plan_detail::class, 'course_plan_id', 'id');
    }
}
