@extends('admin_layout');
@section('admin_content');

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
                </header>
                {{--                <?php--}}
                {{--                $message = Session::get('message');--}}
                {{--                if ($message) {--}}
                {{--                    echo '<span>' . $message . '</span>';--}}
                {{--                    Session::put('message', null);--}}
                {{--                }--}}
                {{----}}
                {{--                ?>--}}
                <div class="panel-body">
                    <div class="position-center">
                        @foreach($edit_product as $key => $pro)
                        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputEmail1"
                                           value="{{$pro->product_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1"
                                           value="{{$pro->product_price}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="product_desc"
                                              id="exampleInputPassword1"
                                              placeholder="Mô tả sản phẩm">{{$pro->product_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tóm tắt sản phẩm</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="product_content"
                                              id="exampleInputPassword1"
                                              placeholder="Mô tả nội dung sản phẩm">{{$pro->product_content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control"
                                           id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" height="100"
                                         width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Danh mục sản phẩm</label>
                                    <select name="product_category" class="form-control input-sm m-bot15">
                                        @foreach($cate_product as $key1 => $value)
                                            @if($value->category_id == $pro->category_id)
                                                <option selected
                                                        value="{{$value->category_id}}">{{$value->category_name}}</option>
                                            @else
                                                <option value="{{$value->category_id}}">{{$value->category_name}}</option>
                                            @endif
                                    </select>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Size</label>
                                    <select name="product_size" class="form-control input-sm m-bot15">
                                        <option value="0">M</option>
                                        <option value="1">L</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Hiển thị</label>
                                    <select name="product_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    </select>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Check me out
                                    </label>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
