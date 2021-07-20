<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Instructor extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'paterno', 'materno', 'cuip', 'curp', 'birth_date', 'address', 'telephone', 'email', 'specialty', 'certifications', 'observations', 'blood_type', 'medical_note', 'type_leave', 'date_leave', 'reason_leave', 'created_by',
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

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'instructor_courses');
    }
}