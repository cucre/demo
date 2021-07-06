<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorCourse extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $fillable = [
        'instructor_id', 'course_id', 'subject_id', 'created_by'
    ];

    public function instructor() {
        return $this->belongsTo(Instructor::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}