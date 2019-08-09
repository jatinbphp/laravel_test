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
