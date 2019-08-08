<?php

namespace App\Http\Controllers;

use App\Model\Country;
use App\Model\Rules;
use App\Model\Types;
use App\Model\TypesCategory;
use App\Model\TypesCategoryRules;
use Illuminate\Http\Request;
use View;

class HomeController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->viewPath = "home";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        View::share("title", "Dashboard");
        $rules = Rules::all();
        $country = Country::pluck("name", "id")->all();
        $types = Types::pluck("name", "id")->all();
        $typesCategory = TypesCategory::pluck("name", "id")->all();
        $rulesList = Rules::pluck("name", "id")->all();

        $categoryRules = [];
        $categoryRules = $this->getCurrentCategoryRules();

        return view($this->viewPath . '.index', compact('rules', 'country', 'types', 'typesCategory', 'rulesList', 'categoryRules'));
    }

    /**
     * [getCurrentCategoryRules description]
     * @param  [type] $countryId [description]
     * @return [type]            [description]
     */
    public function getCurrentCategoryRules()
    {
        $rulesData = [];
        $rec = 0;

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

        return $rulesData;
    }
}
