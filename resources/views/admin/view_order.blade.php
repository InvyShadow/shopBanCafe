@extends('admin_layout')
@section('admin_content')

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Tên người mua</th>
                        <th>Số điện thoại</th>

                        {{--                        <th></th>--}}
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>


                        <td>{{$order_by_id[0]->customer_name}}</td>
                        <td>{{$order_by_id[0]->customer_phone}}</td>


                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Tên người vận chuyển</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>

                        {{--                        <th></th>--}}
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>


                        <td>{{$order_by_id[0]->shipping_name}}</td>
                        <td>{{$order_by_id[0]->shipping_address}}</td>
                        <td>{{$order_by_id[0]->shipping_phone}}</td>


                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Mã giảm giá</th>
                        <th>Tổng tiền</th>
                        {{--                        <th></th>--}}
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_by_id as $key => $v_content)
                    <tr>

                        <td>{{$v_content->product_name}}</td>
                        <td>{{$v_content->product_sales_quantity}}</td>
                        <td>{{$v_content->product_price}}</td>
                        <td>{{$v_content->coupon_code}}</td>
                        <td>{{$v_content->product_price*$v_content->product_sales_quantity}}</td>

                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <a href="{{URL::to("/print-order/".$order_by_id[0]->order_id)}}">In đơn hàng</a>
            </div>

        </div>
    </div>

@endsection
