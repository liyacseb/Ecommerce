<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaxController;
use Illuminate\Support\Facades\Route;


        Route::group(['middleware' => 'adminauth'], function() {
            Route::get('dashboard',[AdminAuthController::class,'dashboard'])->name('dashboard');
            Route::get('contact-setting',[AdminAuthController::class,'contactsetting'])->name('contactsetting');
            Route::post('contact-setting',[AdminAuthController::class,'submitwebsitesetting'])->name('submitwebsitesetting');
            Route::get('change-password',[AdminAuthController::class,'changePassword'])->name('changePassword');
            Route::post('change-password',[AdminAuthController::class,'submitChangePassword'])->name('submitChangePassword');

            Route::prefix('banner/')->middleware(['auth:admin'])->group(function () {
                Route::get('banner-list',[BannerController::class,'index'])->name('bannerList');
                Route::get('banner-listing',[BannerController::class,'bannerListing'])->name('bannerListing');
                Route::get('banner-create',[BannerController::class,'bannercreate'])->name('bannercreate');
                Route::post('banner-store',[BannerController::class,'bannerstore'])->name('bannerstore');
                Route::get('banner-edit/{id}',[BannerController::class,'banneredit'])->name('banneredit');
                Route::get('availableBannerCheck',[BannerController::class,'availableBannerCheck'])->name('availableBannerCheck');
                Route::post('banner-update/{id}',[BannerController::class,'bannerupdate'])->name('bannerupdate');
                Route::get('banner-destroy/{id}',[BannerController::class,'bannerdestroy'])->name('bannerdestroy');
            });

            Route::prefix('category/')->middleware(['auth:admin'])->group(function () {
                Route::get('category-list',[CategoryController::class,'index'])->name('categoryList');
                Route::get('category-listing',[CategoryController::class,'categoryListing'])->name('categoryListing');
                Route::get('category-create',[CategoryController::class,'categorycreate'])->name('categorycreate');
                Route::post('category-store',[CategoryController::class,'categorystore'])->name('categorystore');
                Route::get('category-edit/{id}',[CategoryController::class,'categoryedit'])->name('categoryedit');
                Route::post('category-update/{id}',[CategoryController::class,'categoryupdate'])->name('categoryupdate');
                Route::get('category-destroy/{id}',[CategoryController::class,'categorydestroy'])->name('categorydestroy');
            });

            Route::prefix('color/')->middleware(['auth:admin'])->group(function () {
                Route::get('color-list',[ColorController::class,'index'])->name('colorList');
                Route::get('color-listing',[ColorController::class,'colorListing'])->name('colorListing');
                Route::get('color-create',[ColorController::class,'colorcreate'])->name('colorcreate');
                Route::post('color-store',[ColorController::class,'colorstore'])->name('colorstore');
                Route::get('color-edit/{id}',[ColorController::class,'coloredit'])->name('coloredit');
                Route::post('color-update/{id}',[ColorController::class,'colorupdate'])->name('colorupdate');
                Route::get('color-destroy/{id}',[ColorController::class,'colordestroy'])->name('colordestroy');
            });

            Route::prefix('size/')->middleware(['auth:admin'])->group(function () {
                Route::get('size-list',[SizeController::class,'index'])->name('sizeList');
                Route::get('size-listing',[SizeController::class,'sizeListing'])->name('sizeListing');
                Route::get('size-create',[SizeController::class,'sizecreate'])->name('sizecreate');
                Route::post('size-store',[SizeController::class,'sizestore'])->name('sizestore');
                Route::get('size-edit/{id}',[SizeController::class,'sizeedit'])->name('sizeedit');
                Route::post('size-update/{id}',[SizeController::class,'sizeupdate'])->name('sizeupdate');
                Route::get('size-destroy/{id}',[SizeController::class,'sizedestroy'])->name('sizedestroy');
            });

            Route::prefix('tax/')->middleware(['auth:admin'])->group(function () {
                Route::get('tax-list',[TaxController::class,'index'])->name('taxList');
                Route::get('tax-listing',[TaxController::class,'taxListing'])->name('taxListing');
                Route::get('tax-create',[TaxController::class,'taxcreate'])->name('taxcreate');
                Route::post('tax-store',[TaxController::class,'taxstore'])->name('taxstore');
                Route::get('tax-edit/{id}',[TaxController::class,'taxedit'])->name('taxedit');
                Route::post('tax-update/{id}',[TaxController::class,'taxupdate'])->name('taxupdate');
                Route::get('tax-destroy/{id}',[TaxController::class,'taxdestroy'])->name('taxdestroy');
            });

            Route::prefix('coupon/')->middleware(['auth:admin'])->group(function () {
                Route::get('coupon-list',[CouponController::class,'index'])->name('couponList');
                Route::get('coupon-listing',[CouponController::class,'couponListing'])->name('couponListing');
                Route::get('coupon-create',[CouponController::class,'couponcreate'])->name('couponcreate');
                Route::post('coupon-store',[CouponController::class,'couponstore'])->name('couponstore');
                Route::get('coupon-edit/{id}',[CouponController::class,'couponedit'])->name('couponedit');
                Route::post('coupon-update/{id}',[CouponController::class,'couponupdate'])->name('couponupdate');
                Route::get('coupon-destroy/{id}',[CouponController::class,'coupondestroy'])->name('coupondestroy');
                Route::post('unlimitedcoupon',[CouponController::class,'unlimitedcoupon'])->name('unlimitedcoupon');
            });

            Route::prefix('product/')->middleware(['auth:admin'])->group(function () {
                Route::get('product-list',[ProductController::class,'index'])->name('productList');
                Route::get('product-listing',[ProductController::class,'productListing'])->name('productListing');
                Route::get('product-create',[ProductController::class,'productcreate'])->name('productcreate');
                Route::post('product-store',[ProductController::class,'productstore'])->name('productstore');
                Route::get('product-view/{id}',[ProductController::class,'productview'])->name('productview');
                Route::get('product-edit/{id}',[ProductController::class,'productedit'])->name('productedit');
                Route::post('product-update/{id}',[ProductController::class,'productupdate'])->name('productupdate');
                Route::get('product-destroy/{id}',[ProductController::class,'productdestroy'])->name('productdestroy');
            });
            Route::prefix('stock/')->middleware(['auth:admin'])->group(function () {
                Route::get('stock-list',[StockController::class,'index'])->name('stockList');
                Route::get('stock-listing',[StockController::class,'stockListing'])->name('stockListing');
                Route::get('getprodcolorsize',[StockController::class,'getprodcolorsize'])->name('getprodcolorsize');
                Route::get('stock-create',[StockController::class,'stockcreate'])->name('stockcreate');
                Route::post('stock-store',[StockController::class,'stockstore'])->name('stockstore');
                Route::get('fetchproductstock',[StockController::class,'fetchproductstock'])->name('fetchproductstock');
                Route::get('stock-view/{id}',[StockController::class,'stockview'])->name('stockview');
                Route::get('stock-edit/{id}',[StockController::class,'stockedit'])->name('stockedit');
                Route::post('stock-update/{id}',[StockController::class,'stockupdate'])->name('stockupdate');
                Route::get('stock-destroy/{id}',[StockController::class,'stockdestroy'])->name('stockdestroy');
            });
            Route::prefix('order/')->middleware(['auth:admin'])->group(function () {
                Route::get('order-list',[AdminOrderController::class,'index'])->name('orderList');
                Route::get('order-listing',[AdminOrderController::class,'orderListing'])->name('orderListing');
                Route::get('order-view/{id}',[AdminOrderController::class,'orderview'])->name('orderview');
                Route::post('order-update',[AdminOrderController::class,'orderupdate'])->name('orderupdate');
                Route::post('payment-update',[AdminOrderController::class,'paymentupdate'])->name('paymentupdate');
            });
            Route::prefix('user/')->middleware(['auth:admin'])->group(function () {
                Route::get('user-list',[AdminUserController::class,'index'])->name('userList');
                Route::get('user-listing',[AdminUserController::class,'userListing'])->name('userListing');
                Route::get('individualorderListing,{id}',[AdminUserController::class,'individualorderListing'])->name('individualorderListing');
                Route::get('walletTransaction,{id}',[AdminUserController::class,'walletTransaction'])->name('walletTransaction');
                Route::get('user-view/{id}',[AdminUserController::class,'userView'])->name('userview');
            });
            Route::get('logout',[AdminAuthController::class,'logout'])->name('logout');
            Route::get('test',[TaxController::class,'test'])->name('test');
        });

     