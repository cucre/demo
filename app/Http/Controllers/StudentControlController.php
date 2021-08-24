<?php

namespace App\Http\Controllers;

use App\Course;
use DataTables;
use App\Student;
use Carbon\Carbon;
use App\Corporation;

use App\StudentStatus;
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

    public function data(Request $request) {
        $courses = Course::with(['students'])->orderBy('name')->withTrashed();

        if($request->filled('course')) {
            $courses = $courses->where('id', $request->course);
        }

        if($request->filled('classification')) {
            $courses = $courses->where('classification', $request->classification);
        }

        if($request->filled('status')) {
            if($request->status == 1) {
                $courses = $courses->whereNull('deleted_at');
            } elseif($request->status == 0) {
                $courses = $courses->whereNotNull('deleted_at');
            }            
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $courses = $courses->where(function ($query) use($request) {                        
                return $query->whereDate('start_date', '>=', Carbon::createFromFormat('d/m/Y', $request->start_date))
                             ->whereDate('end_date', '<=', Carbon::createFromFormat('d/m/Y', $request->end_date));
            });
        }

        if($request->filled('name') || $request->filled('paterno') || $request->filled('materno') || $request->filled('cuip') || $request->filled('type') || $request->filled('corporation')) {
            $courses = $courses->whereHas('students', function ($query) use($request) {
                return $query->where('name', 'like', '%'. mb_strtoupper($request->name, 'UTF-8') .'%')
                            ->orWhere('paterno', 'like', '%'. mb_strtoupper($request->paterno, 'UTF-8') .'%')
                            ->orWhere('materno', 'like', '%'. mb_strtoupper($request->materno, 'UTF-8') .'%')
                            ->orWhere('cuip', 'like', '%'. mb_strtoupper($request->cuip, 'UTF-8') .'%')
                            ->orWhere('type', $request->type)
                            ->orWhere('corporation_id', $request->corporation);
            }); 
        }                    

        $datatable = DataTables::eloquent($courses)
            ->addIndexColumn()
            ->editColumn('cuip', function($row) {
                return $row->students->first()->cuip ?? "";
            })
            ->editColumn('full_name', function($row) {
                return $row->students->first()->full_name ?? "";
            })
            ->editColumn('corporation', function($row) {
                return $row->students->first()->corporation->corporation ?? "";
            })
            ->editColumn('type', function($row) {
                return $row->students->first()->type == 1 ? 'Aspirante' : 'Activo';
            })
            ->addColumn('status', function($row) {
                return is_null($row->students->first()->deleted_at) ? 'Activo' : 'Inactivo desde '. $row->students->first()->deleted_at->format('d-m-Y H:i');
            })
            ->addColumn('scores', function($row) {
                return \View::make('students_control.scores')->with(compact('row'))->render();
            })
            ->addColumn('students', function($row) {
                return \View::make('students_control.students')->with(compact('row'))->render();
            })
            ->rawColumns(['status', 'scores', 'students'])
            ->toJson(true);

        return $datatable;
    }
}