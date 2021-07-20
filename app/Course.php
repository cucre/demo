<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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

    public function setStartDateAttribute($start_date) {
        if(env('DB_CONNECTION') == 'mysql') {
            //$this->attributes['start_date'] = Carbon::createFromFormat('Y-m-d', $start_date);
            $this->attributes['start_date'] = date('Y-m-d', strtotime($start_date));
        } else {
            //$this->attributes['start_date'] = Carbon::createFromFormat('d/m/Y', $start_date);
            $this->attributes['start_date'] = date('d/m/Y', strtotime($start_date));
        }
    }

    public function setEndDateAttribute($end_date) {
        if(env('DB_CONNECTION') == 'mysql') {
            $this->attributes['end_date'] = date('Y-m-d', strtotime($end_date));
            //$this->attributes['end_date'] = Carbon::createFromFormat('Y-m-d', $end_date);
        } else {
            //$this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y', $end_date);
            $this->attributes['end_date'] = date('d/m/Y', strtotime($end_date));
        }
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