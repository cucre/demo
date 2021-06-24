@if(is_null($row->deleted_at))
@can('documentos.edit')
	<a href="{{ route('documentos.edit', [$row->id, $row->instructor_id]) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('documentos.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('documentos.delete') }}">
		<input class="instructor_id" type="hidden" name="instructor_id" value="{{ $row->instructor_id }}">
		<input class="document_id" type="hidden" name="document_id" value="{{ $row->id }}">
		<input class="name" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('documentos.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('documentos.restore') }}">
		<input class="instructor_id_res" type="hidden" name="instructor_id_res" value="{{ $row->instructor_id }}">
		<input class="document_id_res" type="hidden" name="document_id_res" value="{{ $row->id }}">
		<input class="name" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif