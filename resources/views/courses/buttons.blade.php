@if(is_null($row->deleted_at))
@can('cursos.edit')
	<a href="{{ route('cursos.edit', $row->id) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('cursos.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('cursos.destroy', $row->id) }}">
		<input class="course" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('cursos.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('cursos.restore') }}">
		<input class="course_id" type="hidden" name="course_id" value="{{ $row->id }}">
		<input class="course" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif