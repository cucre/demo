@if(is_null($row->deleted_at))
<a href="{{ route('corporaciones.edit', $row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
<button href="#" class="btn btn-danger btn-sm eliminar">
	<input class="action" type="hidden" value="{{ route('corporaciones.destroy', $row->id) }}">
	<input class="corporation" type="hidden" value="{{ $row->corporation }}">
	<i class="fas fa-trash"></i> Eliminar
</button>
@else
<button href="#" class="btn btn-warning btn-sm restaurar">
	<input class="action" type="hidden" value="{{ route('corporaciones.restore') }}">
	<input class="corporation_id" type="hidden" name="corporation_id" value="{{ $row->id }}">
	<input class="corporation" type="hidden" value="{{ $row->corporation }}">
	<i class="fas fa-trash-restore"></i> Restaurar
</button>
@endif