@extends('welcome');
@section('content');


<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh giỏ hàng</li>
            </ol>
        </div>
        <!--/breadcrums-->



        <div class="register-req">
            <p>Đăng kí hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div>
        <!--/register-req-->

        <div class="shopper-informations">
            <div class="row">

                <div class="col-sm-10 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin</p>
                        <div class="form-one">
                            <form action="{{URL::to('/save-checkout-customer')}}" method="post">
                                {{csrf_field()}}
                                <input type="text" name="shipping_email" placeholder="Email">
                                <input type="text" name="shipping_name" placeholder="Họ và tên">
                                <input type="text" name="shipping_address" placeholder="Địa chỉ">
                                <input type="text" name="shipping_phone" placeholder="Điện thoại">
                                <textarea name="shipping_note" placeholder="Ghi chú" rows="16"></textarea>
                                <input type="submit" value="GỬI" name="send_order" class="btn btn-primary btn-sm">
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="order-message">
                        <p>Ghi chú đơn hàng</p>


                    </div>
                </div>
            </div>
        </div>
        <div class="review-payment">
            <h2>Giỏ hàng</h2>
        </div>


        <div class="payment-options">
            <span>
                <label><input type="checkbox"> Direct Bank Transfer</label>
            </span>
            <span>
                <label><input type="checkbox"> Check Payment</label>
            </span>
            <span>
                <label><input type="checkbox"> Paypal</label>
            </span>
        </div>
    </div>
</section>
<!--/#cart_items-->

@endsection
