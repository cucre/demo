@can('students_courses.index')
	@if(is_null($row->deleted_at))
	<a href="{{ route('estudiantes_cursos.index', $row->id) }}">
		{{ $row->students->count() ?? "" }} <i class="fas fa-user-graduate"></i>
	</a>
	@else
		{{ $row->students->count() ?? "" }} <i class="fas fa-user-graduate"></i>
	@endif
@endcan