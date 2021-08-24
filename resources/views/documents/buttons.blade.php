@php
    if (Request::route()->named('documentos.data')) {
    	$identificador = $row->instructor_id;
        $ruta_edit = route('documentos.edit', [$row->id, $row->instructor_id]);
        $ruta_delete = route('documentos.delete');
        $ruta_restore = route('documentos.restore');
    } else {
    	$identificador = $row->student_id;
    	$ruta_edit = route('documentos_estudiantes.edit', [$row->id, $row->student_id]);
        $ruta_delete = route('documentos_estudiantes.delete');
        $ruta_restore = route('documentos_estudiantes.restore');
    }
@endphp
@if(is_null($row->deleted_at))
@can('documentos.edit')
	<a href="{{ $ruta_edit }}" class="btn btn-green btn-sm">
		<i class="fas fa-pencil-alt"></i> Editar
	</a>
@endcan
@can('documentos.delete')
	<button href="#" class="btn btn-danger btn-sm eliminar">
		<input class="action" type="hidden" value="{{ $ruta_delete }}">
		<input class="id" type="hidden" name="id" value="{{ $identificador }}">
		<input class="document_id" type="hidden" name="document_id" value="{{ $row->id }}">
		<input class="name" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash"></i> Eliminar
	</button>
@endcan
@else
@can('documentos.restore')
	<button href="#" class="btn btn-warning btn-sm restaurar">
		<input class="action" type="hidden" value="{{ $ruta_restore }}">
		<input class="id_res" type="hidden" name="id_res" value="{{ $identificador }}">
		<input class="document_id_res" type="hidden" name="document_id_res" value="{{ $row->id }}">
		<input class="name" type="hidden" value="{{ $row->name }}">
		<i class="fas fa-trash-restore"></i> Restaurar
	</button>
@endcan
@endif