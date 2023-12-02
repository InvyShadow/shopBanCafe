<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\once;
use App\Models\Category;

class CategoryProduct extends Controller
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

    public function add_category_product()
    {
        $this->auth_login();

        return view('admin.add_category_product');
    }

    public function all_category_product()
    {
        $this->auth_login();
//        $all_category_product = DB::table('tbt_category_product')->get();
        $all_category_product = Category::all();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request)
    {
        $this->auth_login();
//        $data = array();
//        $data['category_name'] = $request->category_product_name;
//        $data['category_desc'] = $request->category_product_desc;
//        $data['category_status'] = $request->category_product_status;
//        DB::table('tbt_category_product')->insert($data);
        $data = $request->all();
        $category = new Category();
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->save();
        Session::put('message', 'Thêm danh mục sản phẩm thành công!');
        return Redirect::to('add-category-product');
    }

    public function unactive_category_product($category_product_id)
    {
        $this->auth_login();
        DB::table('tbt_category_product')->where('category_id', $category_product_id)->update(['category_status' => 1]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công!');
        return Redirect::to('all-category-product');
    }

    public function active_category_product($category_product_id)
    {
        $this->auth_login();
        DB::table('tbt_category_product')->where('category_id', $category_product_id)->update(['category_status' => 0]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công!');
        return Redirect::to('all-category-product');

    }

    public function edit_category_product($category_product_id)
    {
        $this->auth_login();
        $edit_category_product = DB::table('tbt_category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }

    public function update_category_product($category_product_id, Request $req)
    {
        $this->auth_login();
        $data = array();
        $data['category_name'] = $req->category_product_name;
        $data['category_desc'] = $req->category_product_desc;
        DB::table('tbt_category_product')->where('category_id', $category_product_id)->update($data);
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function delete_category_product($category_product_id)
    {
        $this->auth_login();
        DB::table('tbt_category_product')->where('category_id', $category_product_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công!');
        return Redirect::to('all-category-product');
    }
//    End function admin page
    public function show_category_home($category_id) {
        $cate_product = DB::table('tbt_category_product',)->orderBy('category_id', 'desc')->get();
        $category_by_id = DB::table('tbl_product')->join('tbt_category_product', 'tbl_product.category_id','=' , 'tbt_category_product.category_id')->where(
            'tbl_product.category_id' , $category_id
        )->get();
        $category_name = DB::table('tbt_category_product')->where('category_id', $category_id)->get();
        return view('pages.category.show_category')->with('category', $cate_product)->with('category_by_id', $category_by_id)
            ->with('category_name', $category_name);
    }
}
