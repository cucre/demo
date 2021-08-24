{{-- @can('estudiantes.index') --}}
	@if(is_null($row->deleted_at))
	{{-- <a href="{{ route('estudiantes.index', $row->id) }}"> --}}
		<i class="fas fa-graduation-cap"></i>
	</a>
	@else
		<i class="fas fa-graduation-cap"></i>
	@endif
{{-- @endcan --}}