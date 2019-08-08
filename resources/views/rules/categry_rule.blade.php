<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-optin-monster" aria-hidden="true"></i>
        <h3 class="box-title">Rules</h3>
    </div>
    <div class="box-body">
        <table id='rules' class="table table-condensed table-bordered table-hover" style="width:100%">
            <tbody>
                @if(count($rulesData) > 0)
                    @foreach($rulesData as $key => $rule)
                    <tr>
                        <td style="padding-left:20px;">{{($rule['id'])}}</td>
                        <td>{{$rule['name']}}</td>
                        <td>{{$rule['description']}}</td>
                        <td>
                            <a href='javascript:void(0)' data-type="category_rules" data-name="{{$rule['name']}}" data-id="{{$rule['id']}}" data-toggle='tooltip' title='Delete Rules' data-placement='top' class='btn btn-xs btn-danger btn-delete' data-type="rules" data-name="{{$rule['name']}}"><i class='fa fa-fw fa-trash-o fa-lg'></i></a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <Tr>
                        <td colspan="4">
                            No Record was found
                        </td>
                    </Tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
