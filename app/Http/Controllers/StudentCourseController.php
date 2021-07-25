<?php

namespace App\Http\Controllers;

use App\StudentCourse;
use App\Course;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StudentCourseRequest;
use Illuminate\Validation\Rule;

use DataTables;

class StudentCourseController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:students_courses.create')->only(['create', 'store']);
        $this->middleware('permission:students_courses.index')->only(['index', 'data']);
        $this->middleware('permission:students_courses.delete')->only('destroy');
        $this->middleware('permission:students_courses.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $curso) {
        return \View::make('students_courses.index')->with(compact('curso'));
    }

    public function data($course_id = null) {
        $students_courses = StudentCourse::with(['student', 'course'])->where('course_id', $course_id)->withTrashed()->get();

        $datatable = DataTables::of($students_courses)
            ->addIndexColumn()
            ->editColumn('cuip', function($row) {
                return $row->student->cuip;
            })
            ->editColumn('name', function($row) {
                return $row->student->full_name;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('students_courses.buttons')->with(compact('row'))->render();
            })
            ->addColumn('status', function($row) {
                return is_null($row->deleted_at) ? 'Activo' : 'Inactivo desde '. $row->deleted_at->format('d-m-Y H:i');
            })
            ->rawColumns(['status', 'accion'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StudentCourse $estudiante, Course $curso) {
        $students = Student::all();

        return \View::make('students_courses.form')->with(compact('estudiante', 'students', 'curso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentCourseRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        StudentCourse::create($request->all());

        return redirect()->route('estudiantes_cursos.index', $request->course_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentCourse  $studentCourse
     * @return \Illuminate\Http\Response
     */
    public function show(StudentCourse $student_curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentCourse  $studentCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentCourse $student_curso, Course $curso) {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentCourse  $studentCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentCourse $student) {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentCourse  $studentCourse
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        StudentCourse::withTrashed()->findOrFail($request->student_id)->delete();

        return redirect()->route('estudiantes_cursos.index', $request->course_id);
    }

    public function restore(Request $request) {
        StudentCourse::withTrashed()->findOrFail($request->student_id_res)->restore();

        return redirect()->route('estudiantes_cursos.index', $request->course_id_res);
    }
}