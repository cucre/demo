@can('instructors_courses.index')
	@if(is_null($row->deleted_at))
	<a href="{{ route('instructores_cursos.index', $row->id) }}">
		{{ $row->instructors->count() ?? "" }} <i class="fas fa-book-reader"></i>
	</a>
	@else
		{{ $row->instructors->count() ?? "" }} <i class="fas fa-book-reader"></i>
	@endif
@endcan