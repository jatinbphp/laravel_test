<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <title>
        {{Config('myConfig.project_name')}} @if(!empty($title)) | {{$title}} @endif
        </title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
        <meta content="{{ csrf_token() }}" name="_token"/>
        @if(Config('app.env')=="local")
            {{ Html::style("assets/bootstrap/css/bootstrap.min.css") }}
            {{ Html::style('assets/plugins/datatables/dataTables.bootstrap.min.css') }}
            {{ Html::style("assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css") }}
            {{ Html::style("assets/dist/css/ionicons.min.css") }}
            {{ Html::style('assets/plugins/select2/select2.min.css') }}
            {{ Html::style("assets/dist/css/AdminLTE.min.css") }}
            {{ Html::style("assets/dist/css/skins/skin-blue.min.css") }}
            {{ Html::style('assets/plugins/swal/swal.min.css') }}
            {{ Html::style('assets/plugins/colorbox/colorbox.min.css') }}
            {{ Html::style('assets/plugins/jstree/dist/themes/default/style.min.css') }}
            {{ Html::style('assets/plugins/daterangepicker/daterangepicker-bs3.css') }}
            {{ Html::style('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}
            {{ Html::style('assets/plugins/daterangepicker/daterangepicker-bs3.css') }}
            {{ Html::style('assets/dist/css/test.css') }}
        @else
            {{ Html::style("public/assets/bootstrap/css/bootstrap.min.css") }}
            {{ Html::style('public/assets/plugins/datatables/dataTables.bootstrap.min.css') }}
            {{ Html::style("public/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css") }}
            {{ Html::style("public/assets/dist/css/ionicons.min.css") }}
            {{ Html::style('public/assets/plugins/select2/select2.min.css') }}
            {{ Html::style("public/assets/dist/css/AdminLTE.min.css") }}
            {{ Html::style("public/assets/dist/css/skins/skin-blue.min.css") }}
            {{ Html::style('public/assets/plugins/swal/swal.min.css') }}
            {{ Html::style('public/assets/plugins/colorbox/colorbox.min.css') }}
            {{ Html::style('public/assets/plugins/jstree/dist/themes/default/style.min.css') }}
            {{ Html::style('public/assets/plugins/daterangepicker/daterangepicker-bs3.css') }}
            {{ Html::style('public/assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}
            {{ Html::style('public/assets/plugins/daterangepicker/daterangepicker-bs3.css') }}
            {{ Html::style('public/assets/dist/css/test.css') }}
        @endif
        @section("style")
        @show
    </head>
    <body class="hold-transition skin-blue layout-top-nav">
        @include('layout.common.modal')
        <div class="wrapper">
            <div class="content-wrapper">
                <section class="content">
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-md-12">
                            @section("alert")
                            <div id="messsage">
                                <p>
                                </p>
                            </div>
                            @include('layout.common.alert')
                            @show
                            @yield('content')
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <script>
        var public_path = "{!! URL::to('/'); !!}/";
        </script>
        @if(Config('app.env')=="local")
            {{ Html::script("assets/plugins/jQuery/jquery-3.3.1.min.js") }}
            {{ Html::script("assets/bootstrap/js/bootstrap.min.js")}}
            {{ Html::script('assets/plugins/datatables/jquery.dataTables.js') }}
            {{ Html::script('assets/plugins/datatables/dataTables.bootstrap.js') }}
            {{ Html::script('assets/plugins/datatables/dataTables.bootstrap.min.js') }}
            {{ Html::script('assets/plugins/datatables/dataTables.scrollingPagination.js') }}
            {{ Html::script('assets/js/donetyping.js') }}
            {{ Html::script('assets/plugins/colorbox/colorbox.min.js') }}
            {{ Html::script('assets/js/fnStandingRedraw.js') }}
            {{ Html::script("assets/js/jeditable.min.js")}}
            {{ Html::script("assets/js/jquery.livequery.js")}}
            {{ Html::script('assets/plugins/chartjs/Chart.min.js') }}
            {{ Html::script('assets/plugins/swal/swal.min.js') }}
            {{ Html::script("assets/dist/js/app.min.js")}}
            {{ Html::script("assets/dist/js/demo.js")}}
            {{ Html::script('assets/plugins/jstree/dist/jstree.min.js') }}
            {{ Html::script('assets/plugins/daterangepicker/moment.js') }}
            {{ Html::script('assets/js/jquery.form.min.js') }}
            {{ Html::script('assets/plugins/datetimepicker-master/jquery.datetimepicker.full.js') }}
            {{ Html::script('assets/plugins/daterangepicker/daterangepicker.js') }}
            {{ Html::script('assets/plugins/ckeditor/ckeditor.js') }}
            {{ Html::script('assets/plugins/fieldsaddmore/jqery.fieldsaddmore.min.js') }}
            {{ Html::script('assets/plugins/select2/select2.full.js') }}
            {{ Html::script("assets/dist/js/test.js") }}
        @else
            {{ Html::script("public/assets/plugins/jQuery/jquery-3.3.1.min.js") }}
            {{ Html::script("public/assets/bootstrap/js/bootstrap.min.js")}}
            {{ Html::script('public/assets/plugins/datatables/jquery.dataTables.js') }}
            {{ Html::script('public/assets/plugins/datatables/dataTables.bootstrap.js') }}
            {{ Html::script('public/assets/plugins/datatables/dataTables.bootstrap.min.js') }}
            {{ Html::script('public/assets/plugins/datatables/dataTables.scrollingPagination.js') }}
            {{ Html::script('public/assets/js/donetyping.js') }}
            {{ Html::script('public/assets/plugins/colorbox/colorbox.min.js') }}
            {{ Html::script('public/assets/js/fnStandingRedraw.js') }}
            {{ Html::script("public/assets/js/jeditable.min.js")}}
            {{ Html::script("public/assets/js/jquery.livequery.js")}}
            {{ Html::script('public/assets/plugins/chartjs/Chart.min.js') }}
            {{ Html::script('public/assets/plugins/swal/swal.min.js') }}
            {{ Html::script("public/assets/dist/js/app.min.js")}}
            {{ Html::script("public/assets/dist/js/demo.js")}}
            {{ Html::script('public/assets/plugins/jstree/dist/jstree.min.js') }}
            {{ Html::script('public/assets/plugins/daterangepicker/moment.js') }}
            {{ Html::script('public/assets/js/jquery.form.min.js') }}
            {{ Html::script('public/assets/plugins/datetimepicker-master/jquery.datetimepicker.full.js') }}
            {{ Html::script('public/assets/plugins/daterangepicker/daterangepicker.js') }}
            {{ Html::script('public/assets/plugins/ckeditor/ckeditor.js') }}
            {{ Html::script('public/assets/plugins/fieldsaddmore/jqery.fieldsaddmore.min.js') }}
            {{ Html::script('public/assets/plugins/select2/select2.full.js') }}
            {{ Html::script("public/assets/dist/js/test.js") }}
        @endif

        @section('script')
        @show
    </body>
</html>
