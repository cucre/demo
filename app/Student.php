<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path_image', 'corporation_id', 'type', 'name', 'paterno', 'materno', 'cuip', 'birth_date', 'curp', 'cup', 'address', 'telephone', 'email', 'emergency_contact', 'telephone_emergency_contact', 'last_degree', 'workplace', 'job', 'observations', 'blood_type', 'medical_note', 'type_leave', 'date_leave', 'reason_leave', 'created_by',
    ];

    public function setEmailAttribute($email) {
        $this->attributes['email'] = mb_strtolower($email);
    }

    public function setBirthDateAttribute($birth_date) {
        if(env('DB_CONNECTION') == 'mysql') {
            $this->attributes['birth_date'] = Carbon::createFromFormat('Y-m-d', $birth_date);
        } else {
            $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $birth_date);
        }
    }

    public function setDateLeaveAttribute($date_leave) {
        if(env('DB_CONNECTION') == 'mysql') {
            $this->attributes['date_leave'] = Carbon::createFromFormat('Y-m-d', $date_leave);
        } else {
            $this->attributes['date_leave'] = Carbon::createFromFormat('d/m/Y', $date_leave);
        }
    }

    public function getFullNameAttribute() {
        return $this->name .' '. $this->paterno .' '. $this->materno;
    }

    public function getBirthFormatDateAttribute() {
        //return $this->birth_date->format('d/m/Y');
        return date('d/m/Y', $this->birth_date ?? "");
    }

    public function corporation() {
        return $this->belongsTo(Corporation::class);
    }

    public function student_status() {
        return $this->belongsTo(StudentStatus::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    /*public function courses() {
        return $this->belongsToMany(Course::class, 'student_courses');
    }*/
}