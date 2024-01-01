@extends('welcome')
@section('content')
    @foreach($details_product as $key => $value)

        <div class="product-details"><!--product-details-->
            <div class="col-sm-5">
                <div class="view-product">
                    <img  class="image-detail" src="{{URL::to('public/uploads/product/'.$value->product_image)}}"  alt=""/>
                    <h3>ZOOM</h3>
                </div>
                <div id="similar-product" class="carousel slide" data-ride="carousel">

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a>
                        </div>
                        <div class="item">
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a>
                        </div>
                        <div class="item">
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
                            <a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a>
                        </div>

                    </div>

                    <!-- Controls -->
                    <a class="left item-control" href="#similar-product" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right item-control" href="#similar-product" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
            <div class="col-sm-7">
                <div class="product-information"><!--/product-information-->
                    <img src="{{URL::to('public/images/new.jpg')}}" class="newarrival" alt=""/>
                    <h2>{{$value->product_name}}</h2>
                    <img src="{{URL::to('public/images/rating.png')}}" alt=""/>
                    <form action="{{URL::to('/add-cart-ajax')}}" method="post">
                        {{ csrf_field() }}
                        <span>
									<span>{{number_format($value->product_price).' VNĐ'}}</span>
									<label>Số lượng:</label>
									<input name="cart_product_qty" type="number" min="1" value="1"/>
                                    <input name="cart_product_name" type="hidden"  value="{{$value->product_name}}"/>
                                    <input name="cart_product_id" type="hidden"  value="{{$value->product_id}}"/>
                                    <input name="cart_product_image" type="hidden"  value="{{$value->product_image}}"/>
                                    <input name="cart_product_price" type="hidden"  value="{{$value->product_price}}"/>
                                    <input name="cart_product_product_detail" type="hidden"  value="true"/>
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm giỏ hàng
									</button>
								</span>
                    </form>
                    <p><b>Tình trạng:</b> Còn hàng</p>
                    <p><b>Danh múc:</b> {{$value->category_name}}</p>
                    <a href=""><img src="{{URL::to('public/images/share.png')}}" class="share img-responsive"
                                    alt=""/></a>
                </div><!--/product-information-->
            </div>
        </div><!--/product-details-->

        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Chi tiết</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Mô tả sản phẩm</a></li>
                    <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="details">
                    <p>{{!!$value->product_content}}</p>


                </div>

                <div class="tab-pane fade" id="companyprofile">

                    <p>{{$value->product_desc}}</p>


                </div>


                <div class="tab-pane fade" id="reviews">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                            <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                            <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                        </ul>
                        <style type="text/css">
                            .style_comment {
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                background: #F0F0E9;
                                color: #fff;
                            }
                        </style>
                        <form>
                            {{csrf_field()}}
                            <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
                            <div id="comment_show">

                            </div>
                        </form>
                        <p><b>Viết đánh giá của bạn</b></p>

                        <form action="#">
										<span>
											<input style="width: 100%; margin-left: 0" type="text" class="comment_name" placeholder="Tên bình luận"/>

										</span>
                            <textarea name="comment" class="comment_content" placeholder="Nội dung"></textarea>
                            <b>Rating: </b> <img src="images/product-details/rating.png" alt=""/>
                            <button type="button" class="btn btn-default pull-right send-comment">
                                Gửi bình luận
                            </button>
                            <div id="notify_comment"></div>
                        </form>
                    </div>
                </div>

            </div>
        </div><!--/category-tab-->
    @endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach($related as $key => $related_product)
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$related_product->product_id)}}">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img
                                                src="{{URL::to('public/uploads/product/'.$related_product->product_image)}}"
                                                alt=""/>
                                            <h2>{{number_format($related_product->product_price).' VNĐ'}}</h2>
                                            <p>{{$related_product->product_name}}</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Thêm giỏ hàng
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach


                </div>
                <


            </div>

        </div>

    </div>
    </div><!--/recommended_items-->

@endsection
