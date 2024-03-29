<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\Rules;
use App\Model\Types;
use App\Model\TypesCategory;
use App\Model\TypesCategoryRules;
use Illuminate\Http\Request;
use Validator;
use View;

class RulesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->viewPath = "rules";
    }

    /**
     * [getRuleById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getRuleById($id)
    {
        $rules = Rules::where('id', $id)->first();
        $response = [
            'success' => true,
            'rules' => $rules,
        ];

        return response()->json($response, 200);
    }

    /**
     * [delete description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function delete(Request $request)
    {
        View::share("title", "Rules");
        $ids = $request->id;
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Rules::whereIn('id', $ids)->delete();

        $rules = Rules::all();

        $response = [
            'success' => true,
            'html' => view('rules.rule_list', compact('rules'))->render(),
            'ruleList' => Rules::pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [saveRules description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function saveRules(Request $request)
    {
        $data = $request->all();

        if ($request->action == 'new') {
            $rules = [
                'rule_name' => "required|unique:rules,name",
                'description' => "required",
            ];
        } else {
            $id = $data['id'];
            $rules = [
                'rule_name' => "required|unique:rules,name,$id",
                'description' => "required",
            ];
        }

        $message = [
            'rule_name.unique' => 'The rule name must be unique',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->action == 'new') {
            Rules::insert([
                'name' => $request->rule_name,
                'description' => $request->description,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        } else if ($request->action == 'edit') {
            Rules::where("id", $request->id)->update([
                'name' => $request->rule_name,
                'description' => $request->description,
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }

        $rules = Rules::all();

        $response = [
            'success' => true,
            'html' => view('rules.rule_list', compact('rules'))->render(),
            'ruleList' => Rules::pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [getRules description]
     * @return [type] [description]
     */
    public function getRules()
    {
        $rules = Rules::all();
        return view($this->viewPath . '.index', compact('rules'))->render();
    }

    /**
     * [saveCountry description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveCountry(Request $request)
    {
        $data = $request->all();

        $rules = [
            'country_name' => "required|unique:country,name",
        ];
        $message = [
            'country_name.unique' => 'The country name must be unique',
        ];
        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        Country::insert([
            'name' => $request->country_name,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'countries' => Country::pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [updateCountry description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateCountry(Request $request, $countryId)
    {
        $data = $request->all();

        $rules = [
            'country_name' => "required|unique:country,name,$countryId",
        ];
        $message = [
            'country_name.unique' => 'The country name must be unique',
        ];
        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        Country::where("id", $countryId)->update([
            'name' => $request->country_name,
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'countries' => Country::pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteCountry description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteCountry(Request $request)
    {
        $ids = $request->id;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Country::whereIn('id', $ids)->delete();

        $response = [
            'success' => true,
            'countries' => Country::pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [saveTypes description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveTypes(Request $request)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_name' => "required|unique:types,name,NULL,NULL,country_id," . $data['country_id'],
        ];

        $message = [
            'type_name.unique' => 'This type is already exist with this country',
        ];

        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        Types::insert([
            'country_id' => $request->country_id,
            'name' => $request->type_name,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'types' => Types::where("country_id", $data['country_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [updateTypes description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateTypes(Request $request, $typeId)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_name' => "required|unique:types,name,$typeId,id,country_id," . $data['country_id'],
        ];

        $message = [
            'type_name.unique' => 'This type is already exist with this country.',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        Types::where("id", $typeId)->update([
            'country_id' => $request->country_id,
            'name' => $request->type_name,
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'types' => Types::where("country_id", $data['country_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteTypes description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteTypes(Request $request)
    {
        $data = $request->all();

        $ids = $request->id;
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        Types::whereIn('id', $ids)->delete();

        $response = [
            'success' => true,
            'types' => Types::where("country_id", $data['country_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [saveTypesCategory description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveTypesCategory(Request $request)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_id' => "required",
            'types_category_name' => "required|unique:types_category,name,NULL,NULL,type_id," . $data['type_id'],
        ];

        $message = [
            'types_category_name.unique' => 'This category is already exist with this type',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        TypesCategory::insert([
            'country_id' => $request->country_id,
            'type_id' => $request->type_id,
            'name' => $request->types_category_name,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'types_category' => TypesCategory::where("country_id", $data['country_id'])->where("type_id", $data['type_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [updateTypesCategory description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateTypesCategory(Request $request, $typeCategoryId)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_id' => "required",
            'types_category_name' => "required|unique:types_category,name,id,typeCategoryId,type_category_id," . $data['type_category_id'],
            'types_category_name' => "required|unique:types_category,name,id,$typeCategoryId,country_id," . $data['country_id'],
        ];

        $message = [
            'types_category_name.unique' => 'This category is already exist with this type',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        TypesCategory::where("id", $typeCategoryId)->update([
            'country_id' => $request->country_id,
            'type_id' => $request->type_id,
            'name' => $request->types_category_name,
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $response = [
            'success' => true,
            'types_category' => TypesCategory::where("country_id", $data['country_id'])->where("type_id", $data['type_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteTypesCategory description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteTypesCategory(Request $request)
    {
        $data = $request->all();

        $ids = $request->id;
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        TypesCategory::whereIn('id', $ids)->delete();

        $response = [
            'success' => true,
            'types_category' => TypesCategory::where("country_id", $data['country_id'])->where("type_id", $data['type_id'])->pluck("name", "id")->all(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [saveTypesCategoryRules description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveTypesCategoryRules(Request $request)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_id' => "required",
            'type_category_id' => "required",
            'rules_id' => "required|unique:types_category_rules,rules_id,null,null,type_category_id," . $data['type_category_id'],
        ];

        $message = [
            'rules_id.unique' => 'This rules in already in use with this category',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        TypesCategoryRules::insert([
            'country_id' => $request->country_id,
            'type_id' => $request->type_id,
            'type_category_id' => $request->type_category_id,
            'rules_id' => $request->rules_id,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $html = $this->getCurrentRules();

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [getRulesByCategory description]
     * @param  [type] $categoryId [description]
     * @return [type]             [description]
     */
    public function getRulesByCategory(Request $request)
    {
        $typesCategoryId = $request->typesCategoryId;
        $rules = TypesCategoryRules::select("types_category_rules.id", "rules.name", "rules.description")
            ->leftJoin("rules", "rules.id", "=", "types_category_rules.rules_id")
            ->where("types_category_rules.type_category_id", $typesCategoryId);

        $rulesData = [];
        $html = null;

        if ($rules->count() > 0) {
            $rulesData = $rules->get()->toArray();
            $html = view($this->viewPath . '.categry_rule', compact('rulesData'))->render();
        }

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [getTypeByCounry description]
     * @param  [type] $countryId [description]
     * @return [type]            [description]
     */
    public function getTypeByCounry(Request $request)
    {
        $countryId = $request->countryId;
        return Types::where("country_id", $countryId)->pluck("name", "id")->all();
    }

    /**
     * [getCategoryByType description]
     * @param  [type] $countryId [description]
     * @return [type]            [description]
     */
    public function getCategoryByType(Request $request)
    {
        $typeId = $request->typeId;
        return TypesCategory::where("type_id", $typeId)->pluck("name", "id")->all();
    }

    /**
     * [getCurrentCategoryRules description]
     * @param  [type] $countryId [description]
     * @return [type]            [description]
     */
    public function getCurrentCategoryRules()
    {
        $categoryRules = [];

        if (TypesCategoryRules::count() > 0) {
            $countryList = Country::pluck("name", "id")->all();
            $typeList = Types::pluck("name", "id")->all();
            $typeCategoryList = TypesCategory::pluck("name", "id")->all();
            $rulesList = Rules::pluck("name", "id")->all();

            $typeRules = TypesCategoryRules::all()->toArray();
            foreach ($typeRules as $key => $typeRule) {
                $rulesData[$key]['id'] = $typeRule['id'];
                $rulesData[$key]['country_name'] = isset($countryList[$typeRule['country_id']]) ? $countryList[$typeRule['country_id']] : "";
                $rulesData[$key]['type_name'] = isset($typeList[$typeRule['type_id']]) ? $typeList[$typeRule['type_id']] : "";
                $rulesData[$key]['type_category_name'] = isset($typeCategoryList[$typeRule['type_category_id']]) ? $typeCategoryList[$typeRule['type_category_id']] : "";
                $rulesData[$key]['rules_name'] = isset($rulesList[$typeRule['rules_id']]) ? $rulesList[$typeRule['rules_id']] : "";
            }
        }

        $response = [
            'success' => true,
            'html' => view('category.category_rule_list', compact('rulesData'))->render(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteTypesCategoryRules description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteTypesCategoryRules(Request $request)
    {
        $ids = $request->id;
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        TypesCategoryRules::whereIn('id', $ids)->delete();

        $html = $this->getCurrentRules();

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [getTypesCategoryRulesById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getTypesCategoryRulesById($id)
    {
        $rules = TypesCategoryRules::where('id', $id)->first();
        $response = [
            'success' => true,
            'rules' => $rules,
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteCategoryRules description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteCategoryRules(Request $request)
    {
        $ids = $request->id;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        TypesCategoryRules::whereIn('id', $ids)->delete();

        $html = $this->getCurrentRules();

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [deleteCategoryRulesDelete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteCategoryRulesDelete(Request $request)
    {
        $ids = $request->id;

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        TypesCategoryRules::whereIn('id', $ids)->delete();

        $html = $this->getCurrentRules();

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [updateTypesCategoryRules description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateTypesCategoryRules(Request $request, $typeCategoryRuleId)
    {
        $data = $request->all();

        $rules = [
            'country_id' => "required",
            'type_id' => "required",
            'type_category_id' => "required",
            'rules_id' => "required|unique:types_category_rules,rules_id,$typeCategoryRuleId,id,type_category_id," . $data['type_category_id'],
        ];

        $message = [
            'rules_id.unique' => 'This rules in already in use with this category',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        TypesCategoryRules::where("id", $typeCategoryRuleId)->update([
            'country_id' => $request->country_id,
            'type_id' => $request->type_id,
            'type_category_id' => $request->type_category_id,
            'rules_id' => $request->rules_id,
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $html = $this->getCurrentRules();

        $response = [
            'success' => true,
            'html' => $html,
        ];

        return response()->json($response, 200);
    }

    /**
     * [getCurrentRules description]
     * @return [type] [description]
     */
    public function getCurrentRules()
    {
        $html = null;
        if (TypesCategoryRules::count() > 0) {
            $countryList = Country::pluck("name", "id")->all();
            $typeList = Types::pluck("name", "id")->all();
            $typeCategoryList = TypesCategory::pluck("name", "id")->all();
            $rulesList = Rules::pluck("name", "id")->all();

            $typeRules = TypesCategoryRules::all()->toArray();
            foreach ($typeRules as $key => $typeRule) {
                $rulesData[$key]['id'] = $typeRule['id'];
                $rulesData[$key]['country_name'] = isset($countryList[$typeRule['country_id']]) ? $countryList[$typeRule['country_id']] : "";
                $rulesData[$key]['type_name'] = isset($typeList[$typeRule['type_id']]) ? $typeList[$typeRule['type_id']] : "";
                $rulesData[$key]['type_category_name'] = isset($typeList[$typeRule['type_category_id']]) ? $typeList[$typeRule['type_category_id']] : "";
                $rulesData[$key]['rules_name'] = isset($rulesList[$typeRule['rules_id']]) ? $rulesList[$typeRule['rules_id']] : "";
            }

            return view('category.category_rule_list', compact('rulesData'))->render();
        }

        return $html;
    }
}
