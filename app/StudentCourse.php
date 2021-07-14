<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourse extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $fillable = [
        'student_id', 'course_id', 'created_by'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}