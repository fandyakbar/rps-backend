<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Assessment_category_detail extends Model
{
    //
    protected $table = 'assessment_category_details';

    protected $fillable =[
        'course_plan_assessment_id',
        'assessment_category_id',
    ];

   
    public function assessment_category()
    {
        return $this->belongsTo(Assessment_category::class, 'assessment_category_id', 'id');
    }

    public function course_plan_assessment()
    {
        return $this->belongsTo(Course_plan_assessment::class, 'course_plan_assessment_id', 'id');
    }
    
}
