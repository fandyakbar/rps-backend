<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Assessment_category extends Model
{
    //
    protected $table = 'assessment_categories';

    protected $fillable =[
        'name',
    ];

   
    public function assessment_category_detail()
    {
        return $this->hasMany(Assessment_category_detail::class, 'assessment_category_id', 'id');
    }

    public function detail_category()
    {
        return $this->hasMany(Detail_category::class, 'assessment_category_id', 'id');
    }
   
}
