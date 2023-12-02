<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\once;

class ProductController extends Controller
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

    public function add_product()
    {

        $this->auth_login();
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        return view('admin.add_product')->with('category_product', $cate_product);
    }

    public function all_product()
    {
        $this->auth_login();
        $all_product = DB::table('tbl_product')->join('tbt_category_product', 'tbt_category_product.category_id', '=', 'tbl_product.category_id')
            ->orderBy('product_id', 'desc')
            ->get();
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request)
    {
        $this->auth_login();
        $data = array();
        $data['product_id'] = $request->product_id;
        $data['category_id'] = $request->product_category;
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_price'] = $request->product_price;
        $data['product_content'] = $request->product_content;
        $data['product_size'] = $request->product_size;
        $data['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Thêm sản phẩm thành công!');
            return Redirect::to('all-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công!');
        return Redirect::to('add-product');
    }

    public function unactive_product($product_id)
    {
        $this->auth_login();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công!');
        return Redirect::to('all-product');
    }

    public function active_product($product_id)
    {
        $this->auth_login();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công!');
        return Redirect::to('all-product');

    }

    public function edit_product($product_id)
    {
        $this->auth_login();
        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $cate_product = DB::table('tbt_category_product')->orderBy('category_id', 'desc')->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }

    public function update_product($product_id, Request $req)
    {
        $this->auth_login();
        $data = array();
        $data['product_name'] = $req->product_name;
        $data['product_desc'] = $req->product_desc;
        $data['product_price'] = $req->product_price;
        $data['product_content'] = $req->product_content;
        $data['category_id'] = $req->product_category;
        $get_image = $req->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công!');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công!');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id)
    {
        $this->auth_login();
        DB::table('tbt_product')->where('category_id', $product_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công!');
        return Redirect::to('all-product');
    }
//    end admin page
    public function detail_product($product_id) {
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        $details_product = DB::table('tbl_product')->join('tbt_category_product', 'tbt_category_product.category_id','=' , 'tbl_product.category_id')
            ->where('tbl_product.product_id', $product_id)->get();

        foreach ($details_product as $key => $value) {
            $category_id = $value->category_id;
        }
        $related_product = DB::table('tbl_product')->join('tbt_category_product', 'tbt_category_product.category_id','=' , 'tbl_product.category_id')
            ->where('tbl_product.category_id', $category_id )->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.product.show_detail')->with('category', $cate_product)->with('details_product', $details_product)
            ->with('related', $related_product);
    }

}
