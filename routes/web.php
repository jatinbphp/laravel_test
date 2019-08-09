<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'HomeController@index');

Route::resource('rules', 'RulesController', ['except' => ['show', 'destroy']]);

Route::delete('rules/delete', [
    'as' => 'rules.delete',
    'uses' => 'RulesController@delete',
]);

Route::get('rules/get/{rule_id}', [
    'as' => 'rules.get',
    'uses' => 'RulesController@getRuleById',
]);

Route::post('rules/save', [
    'as' => 'rules.save',
    'uses' => 'RulesController@saveRules',
]);

Route::post('country/save', [
    'as' => 'country.save',
    'uses' => 'RulesController@saveCountry',
]);

Route::post('country/update/{country_id}', [
    'as' => 'country.update',
    'uses' => 'RulesController@updateCountry',
]);

Route::post('country/delete', [
    'as' => 'country.delete',
    'uses' => 'RulesController@deleteCountry',
]);

Route::post('types/save', [
    'as' => 'types.save',
    'uses' => 'RulesController@saveTypes',
]);

Route::post('types/update/{types_id}', [
    'as' => 'types.update',
    'uses' => 'RulesController@updateTypes',
]);

Route::post('types/delete', [
    'as' => 'types.delete',
    'uses' => 'RulesController@deleteTypes',
]);

Route::post('types_category/save', [
    'as' => 'types_category.save',
    'uses' => 'RulesController@saveTypesCategory',
]);

Route::post('types_category/update/{types_category_id}', [
    'as' => 'types_category.update',
    'uses' => 'RulesController@updateTypesCategory',
]);

Route::post('types_category/delete', [
    'as' => 'types_category.delete',
    'uses' => 'RulesController@deleteTypesCategory',
]);

Route::post('types_category_rules/save', [
    'as' => 'types_category_rules.save',
    'uses' => 'RulesController@saveTypesCategoryRules',
]);

Route::get('gettype', [
    'as' => 'type.get',
    'uses' => 'RulesController@getTypeByCounry',
]);

Route::get('get_type_category', [
    'as' => 'type_category.get',
    'uses' => 'RulesController@getCategoryByType',
]);

Route::get('get_rule_category', [
    'as' => 'rule_category.get',
    'uses' => 'RulesController@getRulesByCategory',
]);

Route::post('types_category_rules/get/{category_id}', [
    'as' => 'types_category_rules.get',
    'uses' => 'RulesController@getTypesCategoryRulesById',
]);

Route::post('types_category_rules/update/{rules_id}', [
    'as' => 'types_category_rules.update',
    'uses' => 'RulesController@updateTypesCategoryRules',
]);

Route::delete('category_rules/delete', [
    'as' => 'category_rules.delete',
    'uses' => 'RulesController@deleteCategoryRules',
]);

Route::delete('category_rules_delete/delete', [
    'as' => 'category_rules_delete.delete',
    'uses' => 'RulesController@deleteCategoryRulesDelete',
]);
