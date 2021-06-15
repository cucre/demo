<div id="header" class="header navbar-default">
	<!-- begin navbar-header -->
	<div class="navbar-header">
		<a href="{{ route('home') }}" class="navbar-brand">
			<div style="width: 120px; margin-top: 7px; margin-right: 10px; display: block;"><img src="{{ asset('/imgs/colimaestado.png') }}" style="background-color: #393c3e;"></div>
		</a>
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- end navbar-header -->
	<!-- begin header-nav -->
	<ul class="navbar-nav navbar-right">
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<div class="image image-icon bg-black text-grey-darker">
					<i class="fa fa-user"></i>
				</div>
				<span class="d-none d-md-inline">{{ auth()->user()->full_name }}</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="{{ route('logout') }}" class="dropdown-item">Cerrar sesión</a>
			</div>
		</li>
	</ul>
	<!-- end header-nav -->
</div>