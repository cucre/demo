<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'classification', 'hours', 'start_date', 'end_date', 'without_evaluation', 'created_by',
    ];

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'subject_course');
    }

    public function instructors() {
        return $this->belongsToMany(Instructor::class, 'instructor_courses');
    }
}