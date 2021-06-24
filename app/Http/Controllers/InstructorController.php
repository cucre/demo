<?php

namespace App\Http\Controllers;

use App\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\InstructorRequest;

use DataTables;

class InstructorController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:instructores.create')->only(['create', 'store']);
        $this->middleware('permission:instructores.index')->only('index');
        $this->middleware('permission:instructores.edit')->only(['edit', 'update']);
        $this->middleware('permission:instructores.show')->only('show');
        $this->middleware('permission:instructores.delete')->only('destroy');
        $this->middleware('permission:instructores.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('instructors.index');
    }

    public function data() {
        $instructors = Instructor::orderBy('paterno')->withTrashed();

        $datatable = DataTables::eloquent($instructors)
            ->addIndexColumn()
            ->editColumn('name', function($row) {
                return $row->full_name;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('instructors.buttons')->with(compact('row'))->render();
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
    public function create(Instructor $instructore) {
        $action = 'create';

        return \View::make('instructors.form')->with(compact('action', 'instructore'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructorRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        Instructor::create($request->all());

        return redirect()->route('instructores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Instructor  $instructore
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructore) {
        $instructore = $instructore::with(['documents'])->get()->first();
        $action = 'show';

        return \View::make('instructors.form')->with(compact('action', 'instructore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Instructor  $instructore
     * @return \Illuminate\Http\Response
     */
    public function edit(Instructor $instructore) {
        $action = 'edit';

        return \View::make('instructors.form')->with(compact('action', 'instructore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(InstructorRequest $request, Instructor $instructore) {
        $instructore->update($request->all());

        return redirect()->route('instructores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructore) {
        $instructore->delete();

        return redirect()->route('instructores.index');
    }

    public function restore(Request $request) {
        Instructor::withTrashed()->findOrFail($request->instructor_id)->restore();

        return redirect()->route('instructores.index');
    }
}