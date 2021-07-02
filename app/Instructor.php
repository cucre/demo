<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getFullNameAttribute() {
        return $this->name .' '. $this->paterno .' '. $this->materno;
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}