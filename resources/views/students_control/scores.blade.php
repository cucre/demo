{{-- @can('califications.index') --}}
	@if(is_null($row->deleted_at))
	{{-- <a href="{{ route('calificaciones.index', $row->id) }}"> --}}
		<i class="fas fa-clipboard-list"></i>
	</a>
	@else
		<i class="fas fa-clipboard-list"></i>
	@endif
{{-- @endcan --}}