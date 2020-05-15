<?php


use Illuminate\Support\Facades\Route;

Route::namespace('V1')->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login')->name('auth.login');
        Route::post('logout', 'AuthController@logout')->name('auth.logout');
        Route::get('me', 'AuthController@me')->name('auth.me');
        Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
        Route::post('signup', 'AuthController@signUp')->name('auth.signup');
        Route::post('password/forget', 'AuthController@forgetPassword')->name('auth.password.forget');
        Route::post('password/reset', 'AuthController@resetPassword')->name('auth.password.rest');
    });
    Route::prefix('user')->group(function () {

        route::prefix('cart')->group(function () {
            Route::get('', 'CartController@index')->name('user.cart.index');
            Route::post('add', 'CartController@addProductToCart')->name('user.cart.add');
            Route::post('checkout', 'CartController@checkout')->name('user.cart.checkout');
            Route::put('quantity', 'CartController@updateProductQuantity')->name('user.cart.quantity');
            Route::delete('remove_single', 'CartController@removeSingle')->name('user.cart.remove.single');
            Route::delete('remove_multi', 'CartController@removeMulti')->name('user.cart.remove.multi');
            Route::delete('clear', 'CartController@clearCart')->name('user.cart.clear');
        });
        route::prefix('order')->group(function () {
            Route::get('', 'OrderController@index')->name('cart.list');
            Route::get('/{id}', 'OrderController@show')->name('cart.detail');
            Route::put('/pay/{id}', 'OrderController@pay')->name('cart.pay');
            Route::delete('/{id}', 'OrderController@cancleOrder')->name('cart.cancel');
            Route::delete('', 'OrderController@cancleMultiOrder')->name('cart.cancel.multi');
        });
        route::prefix('profile')->group(function () {
            Route::get('', 'UserProfileController@index')->name('user.profile.index');
            Route::put('', 'UserProfileController@store')->name('user.profile.create');
            //必须使用post 方式上传，put patch 都会获取不到文件
            Route::post('/avatar', 'UserProfileController@avatar')->name('user.profile.update');
        });
        route::get('favorite_products', 'UserFavoriteController@favoriteProducts')->name('user.favorite.list');
        route::post('favorite_product', 'UserFavoriteController@favorite')->name('user.favorite');
        route::post('favorite_cancel_product', 'UserFavoriteController@cancelFavorite')->name('user.cancel.favorite');
        route::delete('favorite_clear', 'UserFavoriteController@clearFavorite')->name('user.favorite.clear');

        route::get('like_reviews', 'UserlikeReviewController@likeRreviews')->name('user.unlike');
        route::post('like_review', 'UserlikeReviewController@upProduct')->name('user.like.review');
        route::post('unlike_review', 'UserlikeReviewController@downProduct')->name('user.unlike.review');

    });

    Route::prefix('category')->group(function () {
        Route::get('', 'ProductCategoryController@index');
        Route::get('/{id}', 'ProductCategoryController@show');
//        route::get('/show','ProductController@show');
    });
    Route::prefix('products')->group(function () {
        Route::get('', 'ProductController@index');
        Route::get('/{id}', 'ProductController@show');
        Route::post('/{product}/reviews', 'ProductReview@store');
//        route::get('/show','ProductController@show');
    });
    Route::prefix('sku')->group(function () {
        Route::post('key', 'ProductSkuKeyController@store');
        Route::delete('/{id}', 'ProductSkuKeyController@store');
    });
    Route::namespace('Admin')->prefix('admin')->group(function () {
//        Route::apiResource('product_coupons', 'ProductCouponAPIController');
//        Route::apiResource('addresses', 'AddressAPIController');
//        Route::apiResource('carts', 'CartAPIController');
        Route::prefix('dashboard')->group(function () {
            Route::get('', 'DashboardController@index');
        });
        Route::apiResource('/orders', 'OrderAPIController');
        Route::apiResource('/product_category', 'ProductCategoryAPIController');
        Route::apiResource('/sku_all_attr', 'SkuAttributeKeyAPIController');
        Route::apiResource('/products', 'ProductAPIController');

//        Route::post('/products/{product}/sku', 'ProductAPIController');

//        Route::group(['prefix' => 'products'], function () {
//            Route::apiResource('/{product}/reviews', 'ProductReviewAPIController');
//            Route::apiResource('/{product}/sku', 'ProductSkuAPIController');
//        });
    });
});
//支付宝支付处理
Route::get('alipay/pay', 'AlipayController@pay');
//支付后跳转页面
Route::post('alipay/return', 'AlipayController@result');


Route::fallback(function () {
    return response()->json([
        'message' => request()->url().' Not found',
    ], 404);
})->name('fallback');








