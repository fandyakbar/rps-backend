<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Detail_category extends Model
{
    //
    protected $table = 'detail_categories';

    protected $fillable =[
        'assessment_category_id',
        'assessment_detail_id',
        'value',
    ];

   
    public function assessment_category()
    {
        return $this->belongsTo(Assessment_category::class, 'assessment_category_id', 'id');
    }

   
    public function assessment_detail()
    {
        return $this->belongsTo(Assessment_detail::class, 'assessment_detail_id', 'id');
    }

}
