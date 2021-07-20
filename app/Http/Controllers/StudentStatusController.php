<?php

namespace App\Http\Controllers;

use App\StudentStatus;
use Illuminate\Http\Request;
use App\Http\Requests\StudentStatusRequest;

use DataTables;

class StudentStatusController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:estatus.create')->only(['create', 'store']);
        $this->middleware('permission:estatus.index')->only('index');
        $this->middleware('permission:estatus.edit')->only(['edit', 'update']);
        $this->middleware('permission:estatus.show')->only('show');
        $this->middleware('permission:estatus.delete')->only('destroy');
        $this->middleware('permission:estatus.restore')->only('restore');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('status.index');
    }

    public function data() {
        $status = StudentStatus::orderBy('name')->withTrashed();

        $datatable = DataTables::eloquent($status)
            ->addIndexColumn()
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('status.buttons')->with(compact('row'))->render();
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
    public function create(StudentStatus $estatus) {
        $action = 'create';

        return \View::make('status.form')->with(compact('action', 'estatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStatusRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        StudentStatus::create($request->all());

        return redirect()->route('estatus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(StudentStatus $estatus) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentStatus $estatus) {
        $action = 'edit';

        return \View::make('status.form')->with(compact('action', 'estatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(StudentStatusRequest $request, StudentStatus $estatus) {
        $estatus->update($request->all());

        return redirect()->route('estatus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentStatus $estatus) {
        $estatus->delete();

        return redirect()->route('estatus.index');
    }

    public function restore(Request $request) {
        StudentStatus::withTrashed()->findOrFail($request->status_id)->restore();

        return redirect()->route('estatus.index');
    }
}