<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.web_config.table', 'web_configs');

        Schema::connection($connection)->create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标签名');
            $table->string('name')->comment('配置名称');
            $table->text('value')->nullable()->comment('配置值');
            $table->string('description')->nullable()->comment('描述信息');
            $table->string('field_type')->comment('laravel-admin中存在的表单类型');
            $table->string('field_rules')->nullable()->comment('字段规则');

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
        Schema::dropIfExists('web_configs');
    }
}
