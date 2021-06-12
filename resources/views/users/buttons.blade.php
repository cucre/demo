@if(is_null($row->deleted_at))
<a href="{{ route('usuarios.edit', $row->id) }}" class="btn btn-green btn-sm">
	<i class="fas fa-pencil-alt"></i> Editar
</a>
	@if($row->id != 1)
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('usuarios.destroy', $row->id) }}">
		<input class="user" type="hidden" value="{{ $row->full_name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
	@endif
@else
<button href="#" class="btn btn-warning btn-sm restaurar">
	<input class="action" type="hidden" value="{{ route('usuarios.restore') }}">
	<input class="user_id" type="hidden" name="user_id" value="{{ $row->id }}">
	<input class="user" type="hidden" value="{{ $row->full_name }}">
	<i class="fas fa-trash-restore"></i> Restaurar
</button>
@endif