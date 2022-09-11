<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class degree extends Model
{
    //

    protected $fillable = ['student_id','specializations_id','degree','teacher_id'];


    public function specialized()
    {
        return $this->belongsTo('App\Models\Specialization','specializations_id');
    }

    public function student1()
    {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
