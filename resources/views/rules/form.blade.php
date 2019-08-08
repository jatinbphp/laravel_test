<div class="form-group required">
	<label class="col-sm-3 control-label">Name :-</label>
	<div class="col-sm-7">
		{!! Form::text('name',Input::old('name'),array('class'=>'form-control rulesName','placeholder'=>'Rules Name')) !!}
		<span class="help-inline text-danger" id="name_error"></span>
	</div>
</div>

<div class="form-group required">
	<label class="col-sm-3 control-label">Description :-</label>
	<div class="col-sm-7">
		{!! Form::textarea('description',Input::old('description'),array('class'=>'form-control rulesDescription','placeholder'=>'Rules Description','id'=>'description')) !!}
		<span class="help-inline text-danger" id="description_error"></span>
	</div>
</div>
