<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use function Laravel\Prompts\table;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        SEO
        $meta_desc = 'Shop mua/đặt coffee';
        $meta_keywords = 'coffee, cà phê,mua cafe, shop coffee';
        $meta_title = "N's Coffee";
        $url_canonical = $request->url();
//        End SEO
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderBy('product_id', 'desc')->limit(4)->get();
        return view('pages.home')->with('category', $cate_product)->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }

    public function search(Request $request)
    {

        $keyword = $request->keywords_submit;
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' .$keyword .'%')->where('product_status', 0)->get();
        return view('pages.product.search')->with('category', $cate_product)->with('search_product', $search_product);
    }

    public function send_mail() {
        $to_name = "Phuong Nam";
        $to_mail = "mphuongnam20047@gmail.com";

        $data = array("name"=>"Mail từ tài khoản", "body"=>"Mail gửi về vấn đề hàng hoá");

        Mail::send('pages.send_mail', $data, function ($message) use ($to_name, $to_mail){
            $message->to($to_mail)->subject('Test thử gửi mail google');
            $message->from($to_mail, $to_name);
        });

        return \redirect('')->with('message', '');
    }
}
