<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitUserRelationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('address');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->unique(['id','user_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');

            $table->string('order_num')->unique();
            $table->string('order_status')->default('pay_pending');
            $table->decimal('total_amount', 10, 2)->comment('订单总金额');
            $table->text('address')->nullable()->comment('JSON格式的收货地址');
            $table->text('remark')->nullable()->comment('订单备注');

            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->string('payment_gateway')->nullable()->comment('支付方式');
            $table->string('payment_no')->nullable()->comment('支付平台订单号');
            $table->string('refund_no')->nullable()->comment('退款单号');
            $table->boolean('closed')->default(false)->comment('订单是否已关闭');

            $table->text('ship_data')->nullable()->comment('物流数据');
            $table->text('extra')->nullable()->comment('其他额外的数据');

            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('cart_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->nullable();
            $table->unsignedInteger('quantity');
            $table->timestamps();
            $table->unique(['cart_id', 'product_id', 'sku']);

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->nullable();
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table->unique(['order_id', 'product_id', 'sku']);
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('user_favorite_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');

            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('user_like_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('review_id');
            $table->tinyInteger('like')->comment('-1: down vote, 1: up vote');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('review_id')
                ->references('id')
                ->on('product_reviews')
                ->onDelete('cascade');
        });

        Schema::create('votables', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('votable_id');
            $table->string('votable_type');
            $table->unsignedInteger('vote')->comment('-1: down vote, 1: up vote');
            $table->timestamps();
            $table->unique(['user_id', 'votable_id', 'votable_type']);
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
    }
}
