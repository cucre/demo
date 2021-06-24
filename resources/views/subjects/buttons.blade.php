@if(is_null($row->deleted_at))
@can('materias.edit')
	<a href="{{ route('materias.edit', $row->id) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('materias.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('materias.destroy', $row->id) }}">
		<input class="subject" type="hidden" value="{{ $row->subject }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('materias.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('materias.restore') }}">
		<input class="subject_id" type="hidden" name="subject_id" value="{{ $row->id }}">
		<input class="subject" type="hidden" value="{{ $row->subject }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif