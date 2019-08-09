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
            <tbody class="ruleHtmlList">
                @include("rules.rule_list",['rules'=>$rules])
            </tbody>
        </table>
    </div>
</div>
