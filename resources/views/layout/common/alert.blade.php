@if(Session::get('message') && Session::has('message') != "")
	@if(Session::get('message_type') && Session::has('message_type') != "" )
	<div class="alert  alert-dismissible alert-{{Session::get('message_type')}}" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  	{{Session::get('message')}}
	</div>
	@endif
@endif
