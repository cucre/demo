<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectCourse extends Model {
    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $fillable = [
        'subject_id', 'course_id'
    ];
}