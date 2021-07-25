<?php

namespace App\Http\Controllers;

use App\Document;
use App\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use Illuminate\Support\Facades\Storage;

use DataTables;

class DocumentController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:documentos.create')->only(['create', 'store']);
        $this->middleware('permission:documentos.index')->only(['index', 'data']);
        $this->middleware('permission:documentos.edit')->only(['edit', 'update']);
        $this->middleware('permission:documentos.show')->only('show');
        $this->middleware('permission:documentos.delete')->only('destroy');
        $this->middleware('permission:documentos.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null) {
        return \View::make('documents.index')->with(compact('id'));
    }

    public function data($id = null) {
        $documents = Document::with(['instructor', 'student'])->orderBy('name');

        if (request()->segment(1) == 'list') {
            $documents = $documents->where('instructor_id', $id);
        } else {
            $documents = $documents->where('student_id', $id);
        }

        $documents = $documents->withTrashed()->get();

        $datatable = DataTables::of($documents)
            ->addIndexColumn()
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('path', function($row) {
                return '<a href="'. asset($row->path) .'" download="'. $row->name .'"><em class="fas fa-file-pdf"></em> Descargar</a>';
            })
            ->addColumn('accion', function($row) {
                return \View::make('documents.buttons')->with(compact('row'))->render();
            })
            ->addColumn('status', function($row) {
                return is_null($row->deleted_at) ? 'Activo' : 'Inactivo desde '. $row->deleted_at->format('d-m-Y H:i');
            })
            ->rawColumns(['path', 'status', 'accion'])
            ->toJson(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Document $documento, $id = null) {
        $action = 'create';

        return \View::make('documents.form')->with(compact('action', 'documento', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request) {
        $document = $request->file('path');
        $fileName = '/documents/'. \Str::random(20) .'.'. $document->getClientOriginalExtension();

        Storage::put(
            $fileName,
            file_get_contents($request->file('path')->getRealPath()),
            'public'
        );

        $request->request->add(['created_by' => auth()->user()->id]);
        $requestData = $request->all();
        $requestData['path'] = $fileName;

        Document::create($requestData);

        return redirect()->route($request->ruta_redirect, $request->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $documento, $id = null) {
        $action = 'edit';

        return \View::make('documents.form')->with(compact('action', 'documento', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, Document $documento) {
        $requestData = $request->all();

        if ($request->has('path')) {
            $document = $request->file('path');
            $fileName = '/documents/'. \Str::random(20) .'.'. $document->getClientOriginalExtension();
            Storage::delete($documento->path);

            Storage::put(
                $fileName,
                file_get_contents($request->file('path')->getRealPath()),
                'public'
            );

            Storage::setVisibility($fileName, 'public');

            $requestData['path'] = $fileName;
        }

        $documento->update($requestData);

        return redirect()->route($request->ruta_redirect, $request->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {
        Document::withTrashed()->findOrFail($request->document_id)->delete();

        return redirect()->route($request->ruta_redirect, $request->id);
    }

    public function restore(Request $request) {
        Document::withTrashed()->findOrFail($request->document_id_res)->restore();

        return redirect()->route($request->ruta_redirect_res, $request->id_res);
    }
}