<?php

namespace App\Http\Controllers;

use App\Student;
use App\Corporation;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Storage;

use DataTables;

class StudentController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:estudiantes.create')->only(['create', 'store']);
        $this->middleware('permission:estudiantes.index')->only('index');
        $this->middleware('permission:estudiantes.edit')->only(['edit', 'update']);
        $this->middleware('permission:estudiantes.show')->only('show');
        $this->middleware('permission:estudiantes.delete')->only('destroy');
        $this->middleware('permission:estudiantes.restore')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return \View::make('students.index');
    }

    public function data() {
        $students = Student::with(['corporation'])->orderBy('paterno')->withTrashed();

        $datatable = DataTables::eloquent($students)
            ->addIndexColumn()
            ->editColumn('name', function($row) {
                return $row->full_name;
            })
            ->editColumn('corporation', function($row) {
                return $row->corporation->corporation;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('accion', function($row) {
                return \View::make('students.buttons')->with(compact('row'))->render();
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
     * @param  \App\Student  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function create(Student $estudiante) {
        $action = 'create';
        $corporations = Corporation::all();

        return \View::make('students.form')->with(compact('action', 'estudiante', 'corporations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request) {
        $image = $request->file('path_image');
        $fileName = '/images/'. \Str::random(20) .'.'. $image->getClientOriginalExtension();

        Storage::put(
            $fileName,
            file_get_contents($request->file('path_image')->getRealPath()),
            'public'
        );
        $request->request->add([
            'created_by' => auth()->user()->id,
        ]);
        $requestData = $request->all();
        $requestData['path_image'] = $fileName;

        Student::create($requestData);

        return redirect()->route('estudiantes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Student $estudiante) {
        $estudiante = $estudiante::with(['documents'])->get()->first();
        $action = 'show';

        return \View::make('students.form')->with(compact('action', 'estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $estudiante) {
        $action = 'edit';
        $corporations = Corporation::all();

        return \View::make('students.form')->with(compact('action', 'estudiante', 'corporations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $estudiante) {
        $requestData = $request->all();

        if ($request->has('path_image')) {
            $image = $request->file('path_image');
            $fileName = '/images/'. \Str::random(20) .'.'. $image->getClientOriginalExtension();
            Storage::delete($estudiante->path_image);

            Storage::put(
                $fileName,
                file_get_contents($request->file('path_image')->getRealPath()),
                'public'
            );

            $requestData['path_image'] = $fileName;
        }

        $estudiante->update($requestData);

        return redirect()->route('estudiantes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $estudiante) {
        $messages = [
            'type_leave.required'      => 'El campo Tipo de baja es obligatorio.',
            'type_leave.integer'       => 'El campo Tipo de baja debe ser numérico.',
            'date_leave.required'      => 'El campo Fecha de baja es obligatorio.',
            'reason_leave.required'    => 'El campo Motivo de baja es obligatorio.',
        ];

        $request->validate([
            'type_leave'      => 'required|integer',
            'date_leave'      => 'required',
            'reason_leave'    => 'required',
        ], $messages);

        $estudiante->update($request->all());
        $estudiante->delete();

        return redirect()->route('estudiantes.index');
    }

    public function restore(Request $request) {
        $student = Student::withTrashed()->findOrFail($request->student_id);
        $student->update(['type_leave' => null, 'date_leave' => null, 'reason_leave' => null]);
        $student->restore();

        return redirect()->route('estudiantes.index');
    }
}