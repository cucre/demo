<?php

namespace App\Http\Controllers;

use App\StudentStatus;
use App\Course;
use App\Corporation;
use Illuminate\Http\Request;

class StudentControlController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:control_estudiantes.index')->only(['index', 'data']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $student_status = StudentStatus::all();
        $courses = Course::all();
        $corporations = Corporation::all();

        return \View::make('students_control.index')->with(compact('student_status', 'courses', 'corporations'));
    }
}