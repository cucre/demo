<ol class="breadcrumb float-xl-right">
	@php($ruta = explode('/', request()->path()))
	@foreach($ruta as $item)
		@if($loop->iteration <= 3)
			<li class="breadcrumb-item @if($loop->iteration == $loop->count || $loop->iteration == 3) active @endif">
				{{-- <a href="{{ $item }}"> --}}
					@if($loop->iteration == $loop->count) <strong> @endif
						@if($loop->iteration != 3 || ($loop->iteration == 3 && !is_numeric($item)))
						{{
							Session::get('Breadcrumbs')->contains($item) ?
								Session::get('Breadcrumbs')->filter(function($i) use($item) {
									return $i == $item;
								})->flip()->first() :
								ucfirst($item)
						}}
						@else
							@isset($action)
								@if($action == 'show')
									Ver
								@else
									Editar
								@endif
							@endisset
						@endif
					@if($loop->iteration == $loop->count) </strong> @endif
				{{-- </a> --}}
			</li>
		@endif
	@endforeach
</ol>