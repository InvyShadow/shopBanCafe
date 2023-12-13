<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Frontend
Route::get('/',[HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
//Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);
//Backend
Route::get('/admin' , [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'showDashboard']);
Route::get('/logout', [AdminController::class, 'Log_out']);
Route::post('/admin-dashboard', [AdminController::class, 'Dashboard']);
// Category Product
Route::get('add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::post('update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);
Route::get('delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);

Route::get('all-category-product', [CategoryProduct::class, 'all_category_product']);
Route::get('unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);
Route::post('save-category-product', [CategoryProduct::class, 'save_category_product']);

// Productf

Route::get('add-product', [ProductController::class, 'add_product']);
Route::get('edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::post('update-product/{product_id}', [ProductController::class, 'update_product']);
Route::get('delete-product/{product_id}', [ProductController::class, 'delete_product']);

Route::get('all-product', [ProductController::class, 'all_product']);
Route::get('unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('active-product/{product_id}', [ProductController::class, 'active_product']);
Route::post('save-product', [ProductController::class, 'save_product']);
//Cart
Route::post('save-cart', [CartController::class, 'save_cart']);
Route::post('add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::get('gio-hang', [CartController::class, 'gio_hang']);
Route::post('update-cart', [CartController::class, 'update_cart']);
Route::get('delete-product-cart/{session_id}', [CartController::class, 'delete_product_cart']);
Route::get('delete-all-product-cart', [CartController::class, 'delete_all_product_cart']);

//Checkout
Route::get('login-checkout', [CheckoutController::class, 'login_checkout']);
Route::post('add-customer', [CheckoutController::class, 'add_customer']);
Route::get('checkout', [CheckoutController::class, 'checkout']);
Route::get('logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('login-customer', [CheckoutController::class, 'login_customer']);
Route::get('payment', [CheckoutController::class, 'payment']);
Route::post('order-place', [CheckoutController::class, 'order_place']);



//Coupon
Route::post('check-coupon', [CouponController::class, 'check_coupon']);
Route::get('insert-coupon', [CouponController::class, 'insert_coupon']);
Route::get('list-coupon', [CouponController::class, 'list_coupon']);
Route::post('insert-coupon-code', [CouponController::class, 'insert_coupon_code']);
Route::get('delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);


//Order
Route::get('manage-order', [CheckoutController::class, 'manage_order']);
Route::get('view-order/{order_id}', [CheckoutController::class, 'view_order']);
Route::get('print-order/{order_id}', [CheckoutController::class, 'print_order']);


//Send Mail
Route::get('send-mail', [HomeController::class, 'send_mail']);

//Login Facebook
Route::get('login-facebook', [AdminController::class, 'login_facebook']);
Route::get('admin/callback', [AdminController::class, 'callback_facebook']);

//Login Google
Route::get('login-google', [AdminController::class, 'login_google']);
Route::get('google/callback', [AdminController::class, 'callback_google']);












