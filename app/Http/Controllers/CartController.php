<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {
        $product_id = $request->product_id_hidden;
        $quantity = $request->quantity;
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();

        $data = DB::table('tbl_product')->where('product_id', $product_id)->get();
        return view('pages.cart.show_cart')->with('category', $cate_product);
    }

    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();

        info($data);

        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart) {
            $is_available = 0;
            foreach ($cart as $key => $product) {
                if ($product['product_id'] == $data['cart_product_id']) {
                    $is_available++;
                    $cart[$key] = array(
                        'session_id' => $product['session_id'],
                        'product_name' => $product['product_name'],
                        'product_id' => $product['product_id'],
                        'product_image' => $product['product_image'],
                        'product_qty' => $product['product_qty'] + $data['cart_product_qty'],
                        'product_price' => $product['product_price']
                    );
                };
                Session::put('cart', $cart);
            }
            if ($is_available == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price']
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price']
            );
        }
        Session::put('cart', $cart);
        Session::save();

//        if($data['cart_product_product_detail'=="true"]) {
//            return \redirect("/gio-hang");
//        }
    }

    public function gio_hang(Request $request)
    {
        $meta_desc = "Giỏ hàng của bạn";
        $meta_keyword = "Giỏ hàng Ajax";
        $meta_title = "Giỏ hàng Ajax";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbt_category_product')->orderBy('category_id', 'desc')->get();
        return view('pages.cart.cart_ajax')->with('category', $cate_product);
    }

    public function update_cart(Request $request) {
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $value) {
                    if ($value['session_id'] == $key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
        }
        Session::put('cart', $cart);
        return \redirect()->back()->with('message', 'Cập nhật số lượng thành công');
    }



    public function delete_product_cart($session_id) {
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($cart as $key => $product) {
                if ($session_id == $product['session_id']) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xoá sản phẩm thành công!');
        } else {
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xoá sản phẩm thất bại!');
        }

    }
    public function  delete_all_product_cart() {
        $cart = Session::get('cart');
        if ($cart) {
            Session::forget('cart');
        }
        return redirect()->back()->with('message', 'Xoá sản phẩm thành công!');
    }
    public function check_coupon(Request $request) {
        $data = $request->all();
        print_r($data);

    }


}
