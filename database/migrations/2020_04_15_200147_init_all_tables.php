<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->timestamp('birthday')->nullable();
            $table->string('mobile_phone');
            $table->string('qq');
            $table->string('wechat');
            $table->json('Hobby');
            $table->string('descriptions')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('name')->comment('名称');
            $table->string('image');
            $table->unsignedInteger('parent_id')->nullable()->comment('父类目ID');
            $table->foreign('parent_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id');

            $table->string('title')->comment('商品名称');
            $table->text('description')->comment('商品概要');
            $table->text('content')->comment('商品详情');
            $table->json('attribute_list')
                ->comment('用于前端显示，选择后生成product_sku 的sku_sting属性加上product_id查询具体的sku
                 JSON例：[{"key":"color","name":"颜色","values":["黑色","白色"]}
                ,[“key”："size","name":"屏幕尺寸","values"：[“3.5”,"5.0","6.0"]}]')->default(null);
            $table->string('image')->comment('商品封面');

            $table->boolean('is_sale')->default(true)->comment('否正在售卖');
            $table->float('rating')->default(5)->comment('商品平均评分');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('review_count')->default(0)->comment('评论量');
            $table->unsignedInteger('view_count')->default(0)->comment('查看量');
            $table->decimal('price', 10, 2)->comment('SKU 最低价格');
            $table->unsignedBigInteger('stock')->default(0)->comment('库存');

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');
        });

        Schema::create('product_sku', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('product_id');
            $table->json('sku_json')
                ->comment('json例： [{"key":"color","name":"颜色","value":"黑色"}
                ,[“key”："size","name":"屏幕尺寸","value"：“3.5”}]');
            $table->string('sku_str');
            $table->unsignedInteger('stock')->comment('库存');
            $table->decimal('price', 10, 2)->comment('SKU 价格');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->timestamps();
            $table->unique('sku_str');
            $table->unique(['product_id', 'sku_str']);
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            $table->boolean('is_top')->default(false)->comment('是否置顶');
            $table->string('content')->comment('评论内容');
            $table->unsignedTinyInteger('rating')->default(5)->comment('产品的评论星级');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('product_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('优惠券标题');
            $table->string('code')->unique()->comment('优惠券码，用户下单时输入');
            $table->string('description', 1024)->nullable()->comment('具体描述');
            $table->string('type')->comment('优惠券类型，支持固定金额和百分比折扣');
            $table->decimal('value')->comment('折扣值，根据不同类型含义不同');
            $table->unsignedInteger('total')->comment('全站可兑换的数量');
            $table->unsignedInteger('used')->default(0)->comment('当前已兑换的数量');
            $table->decimal('min_amount', 10, 2)->comment('使用该优惠券的最低订单金额');
            $table->dateTime('start_at')->nullable()->comment('生效开始时间');
            $table->dateTime('expires_at')->nullable()->comment('失效时间');
            $table->boolean('is_active')->comment('优惠券是启用');
            $table->timestamps();
        });
        // 用于构成 属性生成选项，方便管理人员发布商品时候正确的勾选商品属性
        Schema::create('product_sku_attributes_key', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->comment('example: color size');
            $table->string('name')->comment('例：“颜色”，“尺寸”');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
            $table->timestamps();
            $table->unique(['name']);
            $table->unique(['key']);
        });

        Schema::create('product_sku_attributes_value', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('key_id');
            $table->string('value')->default('')->comment('12寸');
            $table->foreign('key_id')
                ->references('id')
                ->on('product_sku_attributes_key')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['key_id', 'value']);
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
        //
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_sku');
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('product_coupons');
        Schema::dropIfExists('product_sku_attributes_key');
        Schema::dropIfExists('product_sku_attributes_value');
    }
}
