<div class="box box-warning">
	<div class="box-header with-border">
		<i class="fa fa-optin-monster" aria-hidden="true"></i>
		<h3 class="box-title">Rules</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<form action="#" accept-charset="UTF-8" class="form-horizontal" id="rules_frm" name="rules_frm">
			@csrf
			<input type="hidden" name="id" id="id" value="" class="rulesId">
			<input type="hidden" name="action" id="action" value="new" class="rulesAction">
			@include("rules.form")
		</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<div class="col-sm-offset-8">
				<button type="submit" class="btn btn-success btnRuleSave"> <i class="fa fa-optin-monster" aria-hidden="true"></i> Save</button>
			</div>
		</div>
	</div>
	</form>
</div>
@section('script')
<script type="text/javascript">
	$('form').submit(function(){
		myShow();
	});
</script>
@stop
