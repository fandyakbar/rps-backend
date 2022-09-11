<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_lo extends Model
{
    //
    protected $table = 'course_los';

    protected $fillable = [
        'course_plan_id',
        'code',
        'name',
      ];

    /**
     * Get the user that owns the Course_los
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course_plan()
    {
        return $this->belongsTo(Course_plan::class, 'course_plan_id', 'id');
    }

    /**
     * Get all of the comments for the Course_los
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_plan_detail_outcome()
    {
        return $this->hasMany(Course_plan_detail_outcome::class, 'course_lo_id', 'id');
    }
    
    public function course_lo_assessment()
    {
        return $this->hasMany(Course_lo_assessment::class, 'course_lo_id', 'id');
    }

    
}
