<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-optin-monster" aria-hidden="true"></i>
        <h3 class="box-title">Categories</h3>
    </div>
    <div class="box-body">
        <table id='rules' class="table table-condensed table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
                    <th style="padding-left:20px;">No</th>
                    <th>Country</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Rules</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="categoryRuleHtmlList">
                @include("category.category_rule_list",['rulesData'=>$categoryRules])
            </tbody>
        </table>
    </div>
</div>
