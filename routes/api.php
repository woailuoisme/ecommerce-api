<?php


use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function (){
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login')->name('auth.login');
        Route::post('logout', 'AuthController@logout')->name('auth.logout');
        Route::get('me', 'AuthController@me')->name('auth.me');
        Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
        Route::post('signup', 'AuthController@signUp')->name('auth.signup');
        Route::post('password/forget', 'AuthController@forgetPassword')->name('auth.password.forget');
        Route::post('password/reset', 'AuthController@resetPassword')->name('auth.password.rest');
    });
    route::prefix('user')->group(function (){
        Route::post('avatar', 'UserController@avatar')->name('user.avatar');
        route::prefix('cart')->group(function () {
            Route::get('', 'CartController@index')->name('user.cart.index');
            Route::post('add', 'CartController@addProductToCart')->name('user.cart.add');
            Route::post('checkout', 'CartController@checkout')->name('user.cart.checkout');
            Route::put('quantity', 'CartController@updateProductQuantity')->name('user.cart.quantity');
            Route::delete('remove_single', 'CartController@removeSingle')->name('user.cart.remove.single');
            Route::delete('remove_multi', 'CartController@removeMulti')->name('user.cart.remove.multi');
            Route::delete('clear', 'CartController@clearCart')->name('user.cart.clear');
        });
        route::prefix('order')->group(function (){
            Route::get('', 'OrderController@index')->name('cart.list');
            Route::get('/{id}', 'OrderController@show')->name('cart.detail');
            Route::post('pay','OrderController@pay')->name('cart.pay');
            Route::delete('/{id}','OrderController@cancleOrder')->name('cart.cancel');
            Route::delete('','OrderController@cancleMultiOrder')->name('cart.cancel.multi');
        });
//        route::prefix('profile')->group(function (){
//            Route::get('','UserProfileController@index')->name('user.profile.index');
//            Route::post('','UserProfileController@store')->name('user.profile.create');
//            //必须使用post 方式上传，put patch 都会获取不到文件
//            Route::post('update','UserProfileController@update')->name('user.profile.update');
//            Route::get('','UserProfileController@show')->name('user.profile.show');
//        });
        route::get('favorite_products','UserController@userFavoriteProducts')->name('user.favorite.list');
        route::post('favorite_product','UserController@favorite')->name('user.favorite');
        route::post('cancel_favorite_product','UserController@cancelFavorite')->name('user.cancel.favorite');
        route::post('like_product','UserController@upProduct')->name('user.like.product');
        route::post('unlike_product','UserController@downProduct')->name('user.unlike.product');

    });
    route::prefix('products')->group(function (){
        route::get('','ProductController@index');
        route::get('/{id}','ProductController@show');
//        route::get('/show','ProductController@show');
    });
    Route::namespace('Admin')->prefix('admin')->group(function(){
        Route::apiResource('product_categories', 'ProductCategoryAPIController');
        Route::apiResource('products', 'ProductAPIController');
        Route::apiResource('product_skus', 'ProductSkuAPIController');
        Route::apiResource('product_reviews', 'ProductReviewAPIController');
        Route::apiResource('product_coupons', 'ProductCouponAPIController');
        Route::apiResource('sku_attribute_keys', 'SkuAttributeKeyAPIController');
        Route::apiResource('sku_attribute_values', 'SkuAttributeValueAPIController');
        Route::apiResource('addresses', 'AddressAPIController');
        Route::apiResource('carts', 'CartAPIController');
        Route::apiResource('orders', 'OrderAPIController');
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => request()->url().' Not found',
    ], 404);
})->name('fallback');








