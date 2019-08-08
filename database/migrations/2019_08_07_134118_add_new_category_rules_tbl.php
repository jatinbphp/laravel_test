<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewCategoryRulesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_category_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("country_id")->nullable();
            $table->integer("type_id")->nullable();
            $table->integer("type_category_id")->nullable();
            $table->integer("rules_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types_category_rules');
    }
}
