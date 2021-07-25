<?php

namespace App\Http\Controllers;

use App\Course;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;

use DataTables;

class CourseController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:cursos.create')->only(['create', 'store']);
        $this->middleware('permission:cursos.index')->only(['index', 'data']);
        $this->middleware('permission:cursos.edit')->only(['edit', 'update']);
        $this->middleware('permission:cursos.show')->only('show');
        $this->middleware('permission:cursos.delete')->only('destroy');
        $this->middleware('permission:cursos.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('courses.index');
    }

    public function data() {
        $courses = Course::with(['instructors', 'students'])->orderBy('name')->withTrashed();

        $datatable = DataTables::eloquent($courses)
            ->addIndexColumn()
            ->editColumn('start_date', function($row) {
                return date('d/m/Y', strtotime($row->start_date));
            })
            ->editColumn('end_date', function($row) {
                return date('d/m/Y', strtotime($row->end_date));
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('instructors', function($row) {
                return \View::make('courses.instructors')->with(compact('row'))->render();
            })
            ->addColumn('students', function($row) {
                return \View::make('courses.students')->with(compact('row'))->render();
            })
            ->addColumn('accion', function($row) {
                return \View::make('courses.buttons')->with(compact('row'))->render();
            })
            ->addColumn('status', function($row) {
                return is_null($row->deleted_at) ? 'Activo' : 'Inactivo desde '. $row->deleted_at->format('d-m-Y H:i');
            })
            ->rawColumns(['instructors', 'students', 'status', 'accion'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $curso) {
        $action = 'create';
        $subjects = Subject::all();

        return \View::make('courses.form')->with(compact('action', 'curso', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
            'without_evaluation' => $request->has('without_evaluation') ? true : false,
        ]);

        $course = Course::create($request->all());
        $course->subjects()->sync($request->subjects);

        return redirect()->route('cursos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Course $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $curso) {
        $action = 'edit';
        $subjects = Subject::all();

        return \View::make('courses.form')->with(compact('action', 'curso', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $curso) {
        $request->request->add([
            'without_evaluation' => $request->has('without_evaluation') ? true : false,
        ]);
        $curso->update($request->all());
        $curso->subjects()->sync($request->subjects);

        return redirect()->route('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $curso) {
        $curso->delete();

        return redirect()->route('cursos.index');
    }

    public function restore(Request $request) {
        Course::withTrashed()->findOrFail($request->course_id)->restore();

        return redirect()->route('cursos.index');
    }

    public function instructors(Course $curso) {
        $action = 'create';
        $subjects = Subject::all();

        return \View::make('courses.form')->with(compact('action', 'curso', 'subjects'));
    }
}