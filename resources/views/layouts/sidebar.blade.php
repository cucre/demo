<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<div class="cover with-shadow"></div>
				<div class="image image-icon bg-black text-grey-darker">
					<i class="fa fa-user"></i>
				</div>
				<div class="info">
					{{ auth()->user()->full_name ?? "" }}
					<small>{{ auth()->user()->roles->first()->description ?? "" }}</small>
				</div>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav"><li class="nav-header">Menú principal</li>

			@foreach(\Session::get('Navigation') as $name => $menu)
				@php($subs = isset($menu['submenu']) ? 'has-sub' : '')
				<li class="{{ $menu['active'] }} {{ $subs }}">
					<a href="{{ $menu['url'] }}">
						@if(isset($menu['submenu']))
							<b class="caret"></b>
						@endif
						<i class="{{ $menu['icon'] }}"></i>
						<span>{{ $name }}</span>
					</a>
					@if(isset($menu['submenu']))
						<ul class="sub-menu">
							@foreach($menu['submenu'] as $submenu)
								<li class="{{ $submenu['active'] }}">
									<a href="{{ $submenu['url'] }}">
										<i class="{{ $submenu['icon'] }}"></i>&nbsp;
										{{ $submenu['name'] }}
									</a>
								</li>
							@endforeach
						</ul>
					@endif
				</li>
			@endforeach
			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>