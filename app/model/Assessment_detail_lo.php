<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Assessment_detail_lo extends Model
{
    //
    protected $table = 'assessment_detail_los';
    
    protected $fillable =[
        'assessment_detail_id',
        'course_lo_id',
    ];
   
    public function assessment_detail()
    {
        return $this->belongsTo(Assessment_detail::class, 'assessment_detail_id', 'id');
    }

   
    public function Course_lo()
    {
        return $this->belongsTo(Course_lo::class, 'course_lo_id', 'id');
    }
}
