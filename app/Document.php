<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'path', 'instructor_id', 'created_by',
    ];

    public function instructor() {
        return $this->belongsTo('App\Instructor', 'instructor_id', 'id');
    }
}