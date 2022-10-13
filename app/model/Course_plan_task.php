<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Course_plan_task extends Model
{
    //
    protected $table = 'course_plan_tasks';
    
    protected $fillable =[
        'course_plan_id',
        'name',
        'theme',
        'description',
        'step',
        'output',
        'member',
    ];

    static $validasi_tambah = [
        'name' => 'required',
        'theme' => 'required',
        'description' => 'required',
        'step' => 'required',
        'output' => 'required',
        'member' => 'required',
    ];

    
    public function Course_plan()
    {
        return $this->belongsTo(Course_plan::class, 'course_plan_id', 'id');
    }
}
