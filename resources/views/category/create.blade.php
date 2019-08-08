<div class="box box-warning">
	<div class="box-header with-border">
		<i class="fa fa-optin-monster" aria-hidden="true"></i>
		<h3 class="box-title">Category</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<form action="#" accept-charset="UTF-8" class="form-horizontal" id="category_frm" name="category_frm">
			<input type="hidden" name="id" id="id" value="" class="categoryId">
			<input type="hidden" name="action" id="action" value="new" class="categoryAction">
			@include("category.form")
		</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<div class="col-sm-offset-10">

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
