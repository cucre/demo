@if(is_null($row->deleted_at))
@can('instructores.edit')
	<a href="{{ route('instructores.edit', $row->id) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('instructores.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('instructores.destroy', $row->id) }}">
		<input class="instructor" type="hidden" value="{{ $row->full_name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('instructores.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('instructores.restore') }}">
		<input class="instructor_id" type="hidden" name="instructor_id" value="{{ $row->id }}">
		<input class="instructor" type="hidden" value="{{ $row->full_name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif