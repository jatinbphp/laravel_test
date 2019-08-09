@extends('layout.index')
@section('content')
<style type="text/css">
  .home .fa {
    color: white;
  }
</style>
<div class="box box-success">
  <div class="box-header with-border">
    <i class="fa fa-home"></i>
    <h3 class="box-title">Welcome To LaravelTest</h3>
  </div>
  <div class="box-body home">
  	<div class="col-lg-5 col-xs-5">
  		@include("rules.create")
  	</div>
  	<div class="col-lg-7 col-xs-5">
		  @include("rules.index")
  	</div>
  </div>
  <div class="box-body home">
    <div class="col-lg-5 col-xs-6">
      @include("category.create")
    </div>
    <div class="col-lg-7 col-xs-6 categoryRuleList">
      @include("category.index")
    </div>
  </div>
</div>
@stop
