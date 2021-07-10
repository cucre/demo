<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('layouts.header')
	@stack('customcss')
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		@include('layouts.navbar')
		<!-- end #header -->

		<!-- begin #sidebar -->
		@include('layouts.sidebar')
		<!-- end #sidebar -->

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			@include('layouts.breadcrumbs')
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">
				@yield('page-header')
			</h1>
			<!-- end page-header -->
			<!-- begin panel -->

			@yield('content')
			<!-- end panel -->
		</div>
		<!-- end #content -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('/assets/js/app.min.js') }}"></script>
	<script src="{{ asset('/assets/js/theme/material.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/select2/dist/js/i18n/es.js') }}"></script>
	<script src="{{ asset('/assets/plugins/sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
	<!-- Utilerias -->
	<script src="{{ asset('/assets/js/utils/func.js') }}"></script>
	<script src="{{ asset('/assets/js/utils/plugins.js') }}"></script>
	<script type="text/javascript">
		$(".alert-danger").fadeTo(5000, 500).slideUp(500, function() {
	    	$(".alert-danger").slideUp(500);
		});
	</script>
	<!-- ================== END BASE JS ================== -->
	@stack('customjs')
</body>
</html>