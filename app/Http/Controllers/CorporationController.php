<?php

namespace App\Http\Controllers;

use App\Corporation;
use Illuminate\Http\Request;
use App\Http\Requests\CorporationRequest;

use DataTables;

class CorporationController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:corporaciones.create')->only(['create', 'store']);
        $this->middleware('permission:corporaciones.index')->only('index');
        $this->middleware('permission:corporaciones.edit')->only(['edit', 'update']);
        $this->middleware('permission:corporaciones.show')->only('show');
        $this->middleware('permission:corporaciones.delete')->only('destroy');
        $this->middleware('permission:corporaciones.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('corporations.index');
    }

    public function data() {
        $corporations = Corporation::orderBy('corporation')->withTrashed();

        $datatable = DataTables::eloquent($corporations)
            ->addIndexColumn()
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('corporations.buttons')->with(compact('row'))->render();
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
    public function create(Corporation $corporacione) {
        $action = 'create';

        return \View::make('corporations.form')->with(compact('action', 'corporacione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorporationRequest $request) {
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);

        Corporation::create($request->all());

        return redirect()->route('corporaciones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Corporations  $corporations
     * @return \Illuminate\Http\Response
     */
    public function show(Corporation $corporation) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Corporation  $corporacione
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporation $corporacione) {
        $action = 'edit';

        return \View::make('corporations.form')->with(compact('action', 'corporacione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Corporations  $corporations
     * @return \Illuminate\Http\Response
     */
    public function update(CorporationRequest $request, Corporation $corporacione) {
        $corporacione->update($request->all());

        return redirect()->route('corporaciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Corporation  $corporation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corporation $corporacione) {
        $corporacione->delete();

        return redirect()->route('corporaciones.index');
    }

    public function restore(Request $request) {
        Corporation::withTrashed()->findOrFail($request->corporation_id)->restore();

        return redirect()->route('corporaciones.index');
    }
}