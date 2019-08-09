<div class="form-group required">
	<div class="col-sm-4">
		{!! Form::select('country',[''=>'Choose Country']+$country,Input::get('country',null),array('class'=>'form-control','id' => 'countryId')) !!}
		<span class="help-inline text-danger clearText" id="country_id_error"></span>
	</div>
	<div class="col-sm-4">
		{!! Form::text('country_name',Input::old('country_name'),array('class'=>'form-control countryName','placeholder'=>'Country Name')) !!}
		<span class="help-inline text-danger clearText" id="country_name_error"></span>
	</div>
	<div class="col-sm-3">
		<div class="countrySave hide">
			<button type="submit" class="btn btn-info btnCountrySave "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Save</button>
		</div>

		<div class="countryUpdate hide">
			<button type="submit" class="btn btn-success btnCountryUpdate "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Update </button>
		</div>

		<div class="countryDelete hide">
			<button type="submit" class="btn btn-danger btnCountryDelete "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Delete </button>
		</div>
	</div>
</div>

<div class="form-group required">
	<div class="col-sm-4">
		{!! Form::select('type',[''=>'Choose Type'],Input::get('type',null),array('class'=>'form-control','id' => 'typeId')) !!}
        <span class="help-inline text-danger clearText" id="type_id_error"></span>
	</div>
	<div class="col-sm-4">
		{!! Form::text('type_name',Input::old('type_name'),array('class'=>'form-control typeName','placeholder'=>'Type Name')) !!}
		<span class="help-inline text-danger clearText" id="type_name_error"></span>
	</div>
	<div class="col-sm-3">
		<div class="typeSave hide">
			<button type="submit" class="btn btn-info btnTypeSave "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Save</button>
		</div>

		<div class="typeUpdate hide">
			<button type="submit" class="btn btn-success btnTypeUpdate "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Update </button>
		</div>

		<div class="typeDelete hide">
			<button type="submit" class="btn btn-danger btnTypeDelete "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Delete </button>
		</div>
	</div>
</div>

<div class="form-group required">
	<div class="col-sm-4">
		{!! Form::select('types_category',[''=>'Choose Category'],Input::get('types_category',null),array('class'=>'form-control','id' => 'typesCategoryId')) !!}
        <span class="help-inline text-danger clearText" id="types_category_id_error"></span>
	</div>
	<div class="col-sm-4">
		{!! Form::text('types_category_name',Input::old('types_category_name'),array('class'=>'form-control typeCategoryName','placeholder'=>'Type Category Name')) !!}
		<span class="help-inline text-danger clearText" id="types_category_name_error"></span>
	</div>
	<div class="col-sm-3">
		<div class="typeCategorySave hide">
			<button type="submit" class="btn btn-info btnTypeCategorySave "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Save</button>
		</div>

		<div class="typeCategoryUpdate hide">
			<button type="submit" class="btn btn-success btnTypeCategoryUpdate "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Update </button>
		</div>

		<div class="typeCategoryDelete hide">
			<button type="submit" class="btn btn-danger btnTypeCategoryDelete "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Delete </button>
		</div>
	</div>
</div>

<div class="form-group required">
	<div class="col-sm-4">
		{!! Form::select('rules_id',[''=>'Choose Rules']+$rulesList,Input::get('rules_id',null),array('class'=>'form-control','id' => 'typesCategoryRulesId')) !!}
        <span class="help-inline text-danger clearText" id="rules_id_error"></span>
	</div>
	<div class="col-sm-3">
		<div class="typeCategoryRulesSave hide">
			<button type="submit" class="btn btn-success btnTypeCategoryRulesSave "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Save</button>
		</div>

		<div class="typeCategoryRulesUpdate hide">
			<button type="submit" class="btn btn-success btnTypeCategoryRulesUpdate "> <i class="fa fa-optin-monster" aria-hidden="true"></i> Update</button>
		</div>
	</div>
</div>
<input type="hidden" name="rules_update_id" class="ruleUpdateId">
<div class="form-group required rulesListHtml">

</div>
