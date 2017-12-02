<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

@if(!Auth::check())
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/animation.js') }}"></script>
<script src="{{ asset('js/stat.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.js') }}"></script>
<script src="{{ asset('js/mdb.min.js') }}"></script>
@endif
<script src="{{ asset('js/functions.js') }}"></script>

{!! Charts::scripts() !!}
@yield('scripts')

<script type="text/javascript">
	$(".button-collapse").sideNav();
	$('.modal').modal();
	
	@if(!Auth::check())
	var scroll = new SmoothScroll('a[href*="#"]');
	new WOW().init();
	@endif

	function deleteExpiredKey() {

		var path = '{{ env('APP_URL') }}' + 'delete/expired/key';

		$.get(path)
		.done(function(response){  
		})
		.fail(function(response){
		});
	}

	// setInterval(deleteExpiredKey, 3000);
</script>