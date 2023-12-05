@extends('welcome');
@section('content')
    ;
    <section id="cart_items">
        <div class="container container-max" style="max-width: 100%">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/update-cart')}}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng
                </ol>
            </div>
            <?php
            $message = Session::get('message');
            if ($message) {
                echo '<span>' . $message . '</span>';
                Session::put('message', null);
            }

            ?>
            <div class="table-responsive cart_info">
                <form action="{{URL::to('/update-cart')}}" method="post">
                    {{csrf_field()}}
                    <table class="table table-condensed">
                        <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh sản phẩm</td>
                            <td class="description">Tên</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $product_cart = Session::get('cart');
                        $total = 0;


                        ?>
                        @if($product_cart)

                            @foreach($product_cart as $key => $cart)
                                    <?php
                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                    $total += $subtotal;
                                    ?>
                                <tr>
                                    <td class="cart_product">
                                        <img class="cart_product_img_ajax"
                                             src="{{URL::to('/public/uploads/product/'.$cart['product_image'])}}"
                                             alt="{{$cart['product_image']}}">
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href=""></a></h4>
                                        <p>{{$cart['product_name']}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{number_format($cart['product_price'],0,',','.')}}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">


                                            <input class="cart_quantity_input" type="number" min="1"
                                                   name="cart_qty[{{$cart['session_id']}}]"
                                                   value="{{$cart['product_qty']}}" autocomplete="off" size="2">


                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">{{number_format($subtotal,0,',','.')}}</p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete"
                                           href="{{URL::to('/delete-product-cart/'.$cart['session_id'])}}"><i
                                                class="fa fa-times"></i></a>
                                    </td>

                                </tr>

                            @endforeach
                            <tr>
                                <td><input type="submit" value="Cập nhật" name="update_qty"
                                           class="check_out btn btn-default btn-sm"></td>
                                <td><a class="btn btn-default check_out" href="{{URL::to('/delete-all-product-cart')}}">Xoá
                                        tất cả</a></td>
                                <td>
                                    <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh
                                        toán</a></td>

                                <td>
                                    <ul>
                                        <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>
                                        {{--                                        <li>Thuế <span></span></li>--}}
                                        {{--                                        <li>Phí vận chuyển <span></span></li>--}}
                                        <li>
                                            @if(Session::get('coupon'))
                                                @foreach(Session::get('coupon') as $key => $coupon)
                                                    @if($coupon['coupon_condition'] == 1 )
                                                        Mã giảm: {{$coupon['coupon_number']}}%
                                                        <p>
                                                                <?php
                                                                $total_coupon = ($total * $coupon['coupon_number']) / 100;
                                                                echo '<p> Tổng giảm: ' . number_format($total_coupon, 0, ',', '.') . 'đ</p>';
                                                                ?>

                                                        </p>
                                        <li><p>Tiền sau khi
                                                giảm: {{number_format($total - $total_coupon, 0 , ',' , '.')}}</p></li>
                                        @else
                                            Mã giảm: {{number_format($coupon['coupon_number'],0,',','.')}}đ
                                            <p>
                                                    <?php
                                                    $total_coupon = $total - $coupon['coupon_number']
//                                                        echo '<p> Tổng giảm: ' . number_format($total_coupon, 0, ',', '.') . 'đ</p>';
                                                    ?>

                                            </p>
                                            <li><p>Tiền sau khi
                                                    giảm: {{number_format($total_coupon, 0 , ',' , '.')}}</p></li>
                                                <?php
                                                Session::put('total', $total_coupon);
                                                $total = $total_coupon
                                                ?>

                                        @endif
                                        @endforeach

                                        @endif

                                        <span></span></li>
                                        {{--                                        <li>Tiền<span></span></li>--}}
                                    </ul>
                                </td>

                            </tr>
                                <?php
                                Session::put('total', $total);
                                ?>

                        @endif

                        </tbody>
                    </table>

                </form>
                <tr>
                    <td colspan="5">
                        <form action="{{URL::to('/check-coupon')}}" method="post">
                            {{csrf_field()}}
                            <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá"> </br>
                            <input type="submit" name="check_coupon" class="btn btn-default check_coupon"
                                   value="Tính mã giảm giá">
                        </form>
                    </td>
                </tr>


            </div>
        </div>
    </section> <!--/#cart_items-->
    {{--    <section id="do_action">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-sm-6">--}}
    {{--                    <div class="total_area">--}}
    {{--                        <ul>--}}
    {{--                            <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>--}}
    {{--                            <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>--}}
    {{--                            <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>--}}
    {{--                            <li>Tổng tiền: <span>{{number_format($total,0,',','.')}}đ</span></li>--}}

    {{--                        </ul>--}}
    {{--                        <a class="btn btn-default check_out" href="" >Thanh toán</a>--}}
    {{--                        <a class="btn btn-default check_out" href="" >Tính mã giảm giá</a>--}}

    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

@endsection
