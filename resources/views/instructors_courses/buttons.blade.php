@if(is_null($row->deleted_at))
@can('instructors_courses.edit')
	<a href="{{ route('instructores_cursos.edit', [$row->id, $row->course_id]) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('instructors_courses.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('instructores_cursos.delete') }}">
		<input class="instructor_id" type="hidden" name="instructor_id" value="{{ $row->id }}">
		<input class="course_id" type="hidden" name="course_id" value="{{ $row->course_id }}">
		<input class="name" type="hidden" value="{{ $row->instructor->cuip .' - '. $row->instructor->full_name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('instructors_courses.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('instructores_cursos.restore') }}">
		<input class="instructor_id_res" type="hidden" name="instructor_id_res" value="{{ $row->id }}">
		<input class="course_id_res" type="hidden" name="course_id_res" value="{{ $row->course_id }}">
		<input class="name" type="hidden" value="{{ $row->instructor->cuip .' - '. $row->instructor->full_name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif