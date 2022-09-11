<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $table = 'courses';
     
    /**
     * Get all of the comments for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan()
    {
        return $this->hasMany(Course_plan::class, 'course_id', 'id');
    }
    
}
