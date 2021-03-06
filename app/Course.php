<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Course extends Model {
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'classification', 'hours', 'start_date', 'end_date', 'without_evaluation', 'created_by',
    ];

    public function setStartDateAttribute($start_date) {
        $this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $start_date);
    }

    public function setEndDateAttribute($end_date) {
        $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $end_date);
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'subject_course');
    }

    public function instructors() {
        return $this->belongsToMany(Instructor::class, 'instructor_courses')->whereNull('instructor_courses.deleted_at');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'student_courses')->whereNull('student_courses.deleted_at');
    }
}