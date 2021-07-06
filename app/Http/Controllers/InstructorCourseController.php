<?php

namespace App\Http\Controllers;

use App\InstructorCourse;
use App\Course;
use App\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\InstructorCourseRequest;
use Illuminate\Validation\Rule;

use DataTables;

class InstructorCourseController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:instructors_courses.create')->only(['create', 'store']);
        $this->middleware('permission:instructors_courses.index')->only('index');
        $this->middleware('permission:instructors_courses.edit')->only(['edit', 'update']);
        $this->middleware('permission:instructors_courses.show')->only('show');
        $this->middleware('permission:instructors_courses.delete')->only('destroy');
        $this->middleware('permission:instructors_courses.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $curso) {
        return \View::make('instructors_courses.index')->with(compact('curso'));
    }

    public function data($course_id = null) {
        $instructors_courses = InstructorCourse::with(['instructor', 'course', 'subject'])->where('course_id', $course_id)->withTrashed()->get();

        $datatable = DataTables::of($instructors_courses)
            ->addIndexColumn()
            ->editColumn('cuip', function($row) {
                return $row->instructor->cuip;
            })
            ->editColumn('name', function($row) {
                return $row->instructor->full_name;
            })
            ->editColumn('subject', function($row) {
                return $row->subject->subject;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('instructors_courses.buttons')->with(compact('row'))->render();
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
    public function create(InstructorCourse $instructor_curso, Course $curso) {
        $action = 'create';
        $instructors = Instructor::all();
        $courses_subjects = Course::with(['subjects'])->where('id', $curso->id)->get()->first();

        return \View::make('instructors_courses.form')->with(compact('action', 'instructor_curso', 'instructors', 'courses_subjects', 'curso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructorCourseRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        InstructorCourse::create($request->all());

        return redirect()->route('instructores_cursos.index', $request->course_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InstructorCourse  $instructorCourse
     * @return \Illuminate\Http\Response
     */
    public function show(InstructorCourse $instructorCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InstructorCourse  $instructorCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(InstructorCourse $instructor_curso, Course $curso) {
        $action = 'edit';
        $instructors = Instructor::all();
        $courses_subjects = Course::with(['subjects'])->where('id', $curso->id)->get()->first();

        return \View::make('instructors_courses.form')->with(compact('action', 'instructor_curso', 'instructors', 'courses_subjects', 'curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InstructorCourse  $instructorCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstructorCourse $instructore) {
        $messages = [
            'instructor_id.required' => 'El campo CUIP/Nombre del instructor es obligatorio.',
            'instructor_id.unique' => 'El campo CUIP/Nombre del instructor ya existe.',
        ];

        $request->validate([
            'instructor_id' => [
                'required',
                Rule::unique('instructor_courses')->where(function ($query) use ($request ,$instructore) {
                   return $query->where('instructor_id', $request->instructor_id)
                      ->where('course_id', $request->course_id)
                      ->where('subject_id', $request->subject_id)
                      ->where('id', '<>', $instructore->id);
                })
            ],
        ], $messages);

        $instructore->update($request->all());

        return redirect()->route('instructores_cursos.index', $request->course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstructorCourse  $instructorCourse
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        InstructorCourse::withTrashed()->findOrFail($request->instructor_id)->delete();

        return redirect()->route('instructores_cursos.index', $request->course_id);
    }

    public function restore(Request $request) {
        InstructorCourse::withTrashed()->findOrFail($request->instructor_id_res)->restore();

        return redirect()->route('instructores_cursos.index', $request->course_id_res);
    }
}