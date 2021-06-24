<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectRequest;

use DataTables;

class SubjectController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:materias.create')->only(['create', 'store']);
        $this->middleware('permission:materias.index')->only('index');
        $this->middleware('permission:materias.edit')->only(['edit', 'update']);
        $this->middleware('permission:materias.show')->only('show');
        $this->middleware('permission:materias.delete')->only('destroy');
        $this->middleware('permission:materias.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('subjects.index');
    }

    public function data() {
        $subjects = Subject::orderBy('subject')->withTrashed();

        $datatable = DataTables::eloquent($subjects)
            ->addIndexColumn()
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('subjects.buttons')->with(compact('row'))->render();
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
    public function create(Subject $materia) {
        $action = 'create';

        return \View::make('subjects.form')->with(compact('action', 'materia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        Subject::create($request->all());

        return redirect()->route('materias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $materia) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $materia) {
        $action = 'edit';

        return \View::make('subjects.form')->with(compact('action', 'materia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $materia) {
        $materia->update($request->all());

        return redirect()->route('materias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $materia) {
        $materia->delete();

        return redirect()->route('materias.index');
    }

    public function restore(Request $request) {
        Subject::withTrashed()->findOrFail($request->subject_id)->restore();

        return redirect()->route('materias.index');
    }
}