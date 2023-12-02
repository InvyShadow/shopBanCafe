@extends('admin_layout');
@section('admin_content')
    ;

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
                </header>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span>' . $message . '</span>';
                    Session::put('message', null);
                }

                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" name="product_name" data-validation="length" data-validation-length="min3"
                                      data-validation-error-msg="Ít nhất 3 kí tự" class="form-control" id="exampleInputEmail1" placeholder="Nhập sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá sản phẩm</label>
                                <input type="text" data-validation="length" data-validation-length="min3"
                                       data-validation-error-msg="Ít nhất 3 kí tự" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Nhập giá">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea style="resize: none" rows="5"  class="form-control" name="product_desc" id="ckeditor1" placeholder="Mô tả sản phẩm"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tóm tắt sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="product_content" id="ckeditor" placeholder="Mô tả nội dung sản phẩm"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Danh mục sản phẩm</label>
                                <select name="product_category" class="form-control input-sm m-bot15">
                                    @foreach($category_product as $key => $value)

                                    <option value="{{$value->category_id}}">{{$value->category_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Size</label>
                                <select name="product_size" class="form-control input-sm m-bot15">
                                    <option value="0">M</option>
                                    <option value="1" >L</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1" >Hiển thị</option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Check me out
                                </label>
                            </div>
                            <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
