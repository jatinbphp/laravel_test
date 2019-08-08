<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\TypesCategory;
use Illuminate\Http\Request;
use Validator;
use View;

class CategoryController extends Controller
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
    public function getCategoryById($id)
    {
        $rules = TypesCategory::where('id', $id)->first();
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
        View::share("title", "Category");
        $ids = $request->id;
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        TypesCategory::whereIn('id', $ids)->delete();
        $response = [
            'success' => true,
            'html' => $this->getCategory(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [saveCategory description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function saveCategory(Request $request)
    {
        $data = $request->all();
        if ($request->action == 'new') {
            $rules = [
                'name' => "required|unique:rules,name",
                'description' => "required",
            ];
        } else {
            $id = $data['id'];
            $rules = [
                'name' => "required|unique:rules,name,$id",
                'description' => "required",
            ];
        }

        $message = [
            'name.unique' => 'The rule name must be unique',
        ];

        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('message_type', 'danger')
                ->with('message', 'There were some error try again');
        }

        if ($request->action == 'new') {
            TypesCategory::insert([
                'name' => $request->name,
                'description' => $request->description,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        } else if ($request->action == 'new') {
            TypesCategory::where("id", $request->id)->update([
                'name' => $request->name,
                'description' => $request->description,
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }

        $response = [
            'success' => true,
            'html' => $this->getCategory(),
        ];

        return response()->json($response, 200);
    }

    /**
     * [getCategory description]
     * @return [type] [description]
     */
    public function getCategory()
    {
        $rules = TypesCategory::all();
        return view($this->viewPath . '.index', compact('rules'))->render();
    }
}
