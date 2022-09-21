<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'role'], function () {
    Route::get('register',[UserAuthController::class,'register'])->name('register');
    Route::post('registration',[UserAuthController::class,'registration'])->name('registration');
    Route::get('userlogin',[UserAuthController::class,'login'])->name('userlogin');
    Route::post('userlogin',[UserAuthController::class,'loginSubmit'])->name('loginSubmit');

    Route::get('userforget-password', [UserAuthController::class, 'showForgetPasswordForm'])->name('user.forget.password.get');
    Route::post('userforget-password', [UserAuthController::class, 'submitForgetPasswordForm'])->name('user.forget.password.post'); 
    Route::get('userreset-password/{token}', [UserAuthController::class, 'showResetPasswordForm'])->name('user.reset.password.get');
    Route::post('userreset-password', [UserAuthController::class, 'submitResetPasswordForm'])->name('user.reset.password.post');
});
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('detail/{id}',[HomeController::class,'detail'])->name('detail');
Route::post('update-cart', [HomeController::class, 'update'])->name('update.cart');
Route::post('product-list', [HomeController::class, 'productlist'])->name('productlist');
Route::get('product-list', [HomeController::class, 'productlistdefault'])->name('productlist');
Route::get('sortbyurl', [HomeController::class, 'sortbyurl'])->name('sortbyurl');
Route::get('sortbyurl', [HomeController::class, 'sortbyurl'])->name('sortbyurl');
Route::get('category/{id}', [HomeController::class, 'category'])->name('category');


Route::post('checkLogin',[UserAuthController::class,'checkLogin'])->name('checkLogin');
    Route::group(['middleware' => ['auth:user']], function() {
        Route::get('customer-account',[CustomerAccountController::class,'index'])->name('customeraccount');
        Route::post('profileUpdate',[CustomerAccountController::class,'profileUpdate'])->name('profileUpdate');
        Route::get('user-change-password',[CustomerAccountController::class,'changepassword'])->name('user.changepassword');
        Route::post('user-change-password',[CustomerAccountController::class,'submitChangePassword'])->name('user.submitChangePassword');
        Route::get('cart',[CartController::class,'index'])->name('cart');
        Route::post('checkout',[CartController::class,'checkout'])->name('checkout');
        Route::get('checkout-address',[CartController::class,'checkoutAddress'])->name('checkoutAddress');
        Route::get('deletecart/{id}',[CartController::class,'deletecart'])->name('deletecart');
        Route::get('couponapply',[CartController::class,'couponapply'])->name('couponapply');
        Route::post('updateCartCount',[CartController::class,'updateCartCount'])->name('updateCartCount');

        Route::post('addressstore',[CustomerAccountController::class,'addressstore'])->name('address.store');
        Route::get('getuseraddress/{id}',[CustomerAccountController::class,'getuseraddress'])->name('address.get');
        Route::post('addressupdate',[CustomerAccountController::class,'addressupdate'])->name('address.update');
        Route::post('addwallet', [CustomerAccountController::class, 'addwallet'])->name('addwallet');
        Route::post('walletrazorpayordercreation', [CustomerAccountController::class, 'walletrazorpayordercreation'])->name('walletrazorpayordercreation');
        Route::post('walletaddfailed', [CustomerAccountController::class, 'walletaddfailed'])->name('walletaddfailed');

        Route::post('checkoutaddress',[CheckoutController::class,'index'])->name('checkoutaddress');
        Route::get('paymentform',[CheckoutController::class,'paymentform'])->name('paymentform');
        Route::post('checkoutpayment',[CheckoutController::class,'checkoutpayment'])->name('checkoutpayment');
        Route::get('orderPreview',[CheckoutController::class,'orderPreview'])->name('orderPreview');
        Route::post('order',[CheckoutController::class,'order'])->name('order');

        Route::post('razorpay-payment-store',[RazorpayPaymentController::class,'store'])->name('razorpay.payment.store');
        Route::post('payment-failure-store',[CheckoutController::class,'paymentfail'])->name('payment.failure.store');
        
        Route::get('stripe', [StripePaymentController::class, 'index']);
        Route::post('payment-process', [StripePaymentController::class, 'process'])->name('stripe.payment.process');

        Route::post('wallet-payment-process', [OrderController::class, 'walletpaymentprocess'])->name('wallet.payment.process');

        Route::post('cod-order-store',[OrderController::class,'store'])->name('cod.order.store');
        Route::get('orders',[OrderController::class,'index'])->name('orders');
        Route::get('order-detail/{id}',[OrderController::class,'orderdetail'])->name('orderdetail');

        Route::get('userLogout',[UserAuthController::class,'userLogout'])->name('userLogout');
    });