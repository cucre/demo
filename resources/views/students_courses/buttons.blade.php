@if(is_null($row->deleted_at))
@can('students_courses.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('estudiantes_cursos.delete') }}">
		<input class="student_id" type="hidden" name="student_id" value="{{ $row->id }}">
		<input class="course_id" type="hidden" name="course_id" value="{{ $row->course_id }}">
		<input class="name" type="hidden" value="{{ $row->student->cuip .' - '. $row->student->full_name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('students_courses.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('estudiantes_cursos.restore') }}">
		<input class="student_id_res" type="hidden" name="student_id_res" value="{{ $row->id }}">
		<input class="course_id_res" type="hidden" name="course_id_res" value="{{ $row->course_id }}">
		<input class="name" type="hidden" value="{{ $row->student->cuip .' - '. $row->student->full_name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif