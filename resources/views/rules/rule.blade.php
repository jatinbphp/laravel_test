<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-optin-monster" aria-hidden="true"></i>
        <h3 class="box-title">Rules</h3>
    </div>
    <div class="box-body">
        <table id='rules' class="table table-condensed table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
                    <th style="padding-left:20px;">No</th>
                    <th>Rules Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($rules) > 0)
                    @foreach($rules as $key => $rule)
                    <tr>
                        <td style="padding-left:20px;">{{($rule->id)}}</td>
                        <td>{{$rule->name}}</td>
                        <td>{{$rule->description}}</td>
                        <td>
                            <a href='javascript:void(0)' data-name="{{$rule->name}}" data-id="{{$rule->id}}" data-toggle='tooltip' title='Delete Rules' data-placement='top' class='btn btn-xs btn-danger btn-delete' data-type="rules" data-name="{{$rule->name}}"><i class='fa fa-fw fa-trash-o fa-lg'></i></a>
                        </td>
                    </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>
