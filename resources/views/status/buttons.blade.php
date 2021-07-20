@if(is_null($row->deleted_at))
@can('estatus.edit')
	<a href="{{ route('estatus.edit', $row->id) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('estatus.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('estatus.destroy', $row->id) }}">
		<input class="status" type="hidden" value="{{ $row->status }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('estatus.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('estatus.restore') }}">
		<input class="status_id" type="hidden" name="status_id" value="{{ $row->id }}">
		<input class="status" type="hidden" value="{{ $row->status }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif