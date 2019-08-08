<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-optin-monster" aria-hidden="true"></i>
        <h3 class="box-title">All Rules</h3>
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
                            <a href="{{route('rules.edit',$rule->id)}}" data-toggle='tooltip' title='Edit Rules' data-id="{{$rule->id}}" data-placement='top' class='btn btn-primary btn-xs btnRuleEdit'>Edit</a>
                            &nbsp;
                            <a href='javascript:void(0)' data-name="{{$rule->name}}" data-id="{{$rule->id}}" data-toggle='tooltip' title='Delete Rules' data-placement='top' class='btn btn-xs btn-danger btn-delete' data-type="rules" data-name="{{$rule->name}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <Td colspan='4'>
                            There is no record was found
                        </Td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
