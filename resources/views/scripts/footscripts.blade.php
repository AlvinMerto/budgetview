<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap -->
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- overlayScrollbars -->
		<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('dist/js/adminlte.js')}}"></script>

		<!-- PAGE PLUGINS -->
		<!-- jQuery Mapael -->
		<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
		<script src="{{ asset('plugins/raphael/raphael.min.js')}}"></script>
		<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
		<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
		<!-- ChartJS -->
		<script src="{{ asset('plugins/chart.js/Chart.min.js')}}"></script>

		<!-- AdminLTE for demo purposes -->
		<!-- <script src="{{ asset('dist/js/demo.js')}}"></script> -->
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!-- <script src="{{ asset('dist/js/pages/dashboard2.js')}}"></script> -->
		<script src="{{ asset('dist/js/pages/dashboard3.js')}}"></script>

<!-- input window -->

		<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
		<!-- Bootstrap4 Duallistbox -->
		<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
		<!-- InputMask -->
		<script src="{{ asset('plugins/moment/moment.min.js')}}"></script>
		<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
		<!-- date-range-picker -->
		<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
		<!-- bootstrap color picker -->
		<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
		<!-- Bootstrap Switch -->
		<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
		<!-- BS-Stepper -->
		<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
		<!-- dropzonejs -->
		<script src="{{ asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
		<!-- Bootstrap -->
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

		<script>
			function ajaxsetup() {
			    $.ajaxSetup({
			        headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
			    });
			}

			ajaxsetup();
		</script>