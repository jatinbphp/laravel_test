@if(count($rulesData) > 0)
    @foreach($rulesData as $key => $categoryRule)
    <tr>
        <td style="padding-left:20px;">{{$categoryRule['id']}}</td>
        <td>{{$categoryRule['country_name']}}</td>
        <td>{{$categoryRule['type_name']}}</td>
        <td>{{$categoryRule['type_category_name']}}</td>
        <td>{{$categoryRule['rules_name']}}</td>
        <td>
            <a href="{{route('rules.edit',$categoryRule['id'])}}" data-toggle='tooltip' title='Edit Rules' data-type="category_rules_edit" data-id="{{$categoryRule['id']}}" data-placement='top' class='btn btn-primary btn-xs btnCategoryRuleEdit'>Edit</a>
            &nbsp;
            <a href='javascript:void(0)' data-type="category_rules_delete" data-name="{{$categoryRule['id']}}" data-id="{{$categoryRule['id']}}" data-toggle='tooltip' title='Delete Category Rules' data-placement='top' class='btn btn-xs btn-danger btn-delete'>Delete</a>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <Td colspan='7'>
            There is no record was found
        </Td>
    </tr>
@endif
