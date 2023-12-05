<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\once;

session_start();

class CheckoutController extends Controller
{
    public function auth_login()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function login_checkout()
    {
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        if (Session::get('customer_name')) {
            return view('pages.checkout.checkout')->with('category', $cate_product);
        }
        return view('pages.checkout.login_checkout')->with('category', $cate_product);
    }

    public function add_customer(Request $request)
    {

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_email'] = $request->customer_email;

        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return Redirect::to('/checkout');

    }

    public function checkout()
    {
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();


        return view('pages.checkout.checkout')->with('category', $cate_product);
    }

    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }

    public function payment()
    {
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();


        return view('pages.checkout.payment')->with('category', $cate_product);
    }

    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/login-checkout');

    }

    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);

        $result = DB::table('tbl_customer')->where('customer_email', $email)->where('customer_password', $password)->first();

        if ($result) {
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            return Redirect::to('/checkout');
        } else {
            return Redirect::to('/login-checkout');
        }

    }

    public function order_place(Request $request)
    {
//        Insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lí';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

//        Insert order
        $order_data = array();

        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Session::get('total');
        $order_data['order_status'] = 'Đang chờ xử lí';
        if (Session::get('coupon')) {
            foreach (Session::get('coupon') as $key => $coupon_code)
                $order_data['coupon_code'] = $coupon_code['coupon_code'];
        } else {
            $order_data['coupon_code'] = 'No';
        }
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

//        Insert order detail
        $product_cart = Session::get('cart');
        foreach ($product_cart as $key => $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content['product_id'];
            $order_d_data['product_name'] = $v_content['product_name'];
            $order_d_data['product_price'] = $v_content['product_price'];
            $order_d_data['product_sales_quantity'] = $v_content['product_qty'];
            DB::table('tbl_order_detail')->insert($order_d_data);
        }

        if ($data['payment_method'] == 1) {
            echo 'thanh toán bằng thẻ atm';
        } else if ($data['payment_method'] == 2) {
            Session::flash('cart');
            $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
            return view('pages.checkout.handcash')->with('category', $cate_product);
        }


    }

    public function manage_order()
    {
        $this->auth_login();
        $all_order = DB::table('tbl_order')->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->select('tbl_order.*', 'tbl_customer.customer_name')
            ->orderBy('tbl_order.order_id', 'desc')
            ->get();
        $manage_order = view('admin.manage_order')->with('all_order', $all_order);


        return view('admin_layout')->with('admin.manage_order', $manage_order);
    }

    public function view_order($order_id)
    {

        $this->auth_login();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_detail', 'tbl_order.order_id', '=', 'tbl_order_detail.order_id')
            ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_detail.*')
            ->where('tbl_order.order_id', $order_id)
            ->get();
//echo '<pre>';
//print_r($order_by_id);
//echo '</pre>';
        $manage_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);


        return view('admin_layout')->with('admin.view_order', $manage_order_by_id);
    }
}
