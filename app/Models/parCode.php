<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class parCode extends Model
{
    protected $table = 'qr_codes';
    protected $guarded=[];

    public function Student()
    {
        return $this->hasOne('App\Models\Student','student_id');
    }
}
