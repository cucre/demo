@if(is_null($row->deleted_at))
@can('estudiantes.edit')
	<a href="{{ route('estudiantes.edit', $row->id) }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('estudiantes.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ route('estudiantes.destroy', $row->id) }}">
		<input class="student" type="hidden" value="{{ $row->full_name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@can('documentos.index')
	<a href="{{ route('documentos_estudiantes.index', $row->id) }}" class="btn btn-blue btn-sm">
		<i class="fas fa-file"></i> Documentos
	</a>
@endcan
@else
@can('estudiantes.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ route('estudiantes.restore') }}">
		<input class="student_id" type="hidden" name="student_id" value="{{ $row->id }}">
		<input class="student" type="hidden" value="{{ $row->full_name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif
@can('estudiantes.show')
	<a href="{{ route('estudiantes.show', $row->id) }}" class="btn btn-orange btn-sm">
		<i class="fas fa-eye"></i> Ver
	</a>
@endcan