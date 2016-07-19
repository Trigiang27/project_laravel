@extends('user.master')
@section('content')
  <section id="product">
    <div class="container">
     <!--  breadcrumb -->  
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Category</li>
      </ul>
      <div class="row">        
        <!-- Sidebar Start-->
        <aside class="span3">
         <!-- Category-->  
          <div class="sidewidt">
            <h2 class="heading2"><span>Categories</span></h2>
            <ul class="nav nav-list categories">
              @foreach($menu_cate as $cate)
              <li>
                <a href="category.html">{!! $cate->name !!}</a>
              </li>
              @endforeach
            </ul>
          </div>
         <!--  Best Seller -->  
          <div class="sidewidt">
            <h2 class="heading2"><span>Best Seller</span></h2>
            <ul class="bestseller">
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Women Accessories</span>
                <span class="price">$250</span>
              </li>
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Electronics</span>
                <span class="price">$250</span>
              </li>
              <li>
                <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product">
                <a class="productname" href="product.html"> Product Name</a>
                <span class="procategory">Electronics</span>
                <span class="price">$250</span>
              </li>
            </ul>
          </div>
          <!-- Latest Product -->  
          <div class="sidewidt">
            <h2 class="heading2"><span>Latest Products</span></h2>
            <ul class="bestseller">
              {!! $key = 0 !!}
              @foreach($lastest_product as $product)
              <li>
                <img width="50" height="50" src="{!! url(asset('resources/upload/'.$product->image)) !!}" alt="product" title="product">
                <a class="productname" href="{!! url('chi-tiet-san-pham',[$product->id,$product->alias]) !!}">{!! $product->name !!}</a>
                <span class="procategory">{!! $cate_product[$key++] !!}</span>
                <span class="price">{!! number_format($product->price,0,',','.') !!}</span>
              </li>
              @endforeach
            </ul>
          </div>
          <!--  Must have -->  
          <div class="sidewidt">
          <h2 class="heading2"><span>Must have</span></h2>
          <div class="flexslider" id="mainslider">
            <ul class="slides">
              <li>
                <img src="img/product1.jpg" alt="" />
              </li>
              <li>
                <img src="img/product2.jpg" alt="" />
              </li>
            </ul>
          </div>
          </div>
        </aside>
        <!-- Sidebar End-->
        <!-- Category-->
        <div class="span9">          
          <!-- Category Products-->
          <section id="category">
            <div class="row">
              <div class="span9">
               <!-- Category-->
                <section id="categorygrid">
                  <ul class="thumbnails grid">
                  @foreach($product_cate as $item_product_cate)
                    <li class="span3">
                      <a class="prdocutname" href="{!! url('chi-tiet-san-pham',[$item_product_cate->id,$item_product_cate->alias]) !!}">{!! $item_product_cate->name !!}</a>
                      <div class="thumbnail">
                        <span class="sale tooltip-test">Sale</span>
                        <a href="{!! url('chi-tiet-san-pham',[$item_product_cate->id,$item_product_cate->alias]) !!}"><img alt="" src="{!! URL(asset('resources/upload/'.$item_product_cate->image)) !!}"></a>
                        <div class="pricetag">
                          <span class="spiral"></span><a href="{!! url('mua-hang',[$item_product_cate->id,$item_product_cate->alias]) !!}" class="productcart">ADD TO CART</a>
                          <div class="price">
                            <div class="pricenew">{!! number_format($item_product_cate->price,0,',','.') !!}</div>
                            <div class="priceold"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                  Tong so trang {!! $product_cate->lastPage() !!}
                  <div class="pagination pull-right">
                    <ul>
                      @if($product_cate->currentPage() != 1)
                      <li><a href="{!! str_replace('/?','?',$product_cate->url($product_cate->currentPage()-1)) !!}">Prev</a></li>
                      @endif
                      @for($i = 1 ; $i <= $product_cate->lastPage() ; $i++)
                      <li class="{!! ($product_cate->currentPage() == $i ? "active" : "") !!}">
                        <a href="{!! str_replace('/?','?',$product_cate->url($i)) !!}">{!! $i !!}</a>
                      </li>
                      @endfor
                      @if($product_cate->currentPage() != $product_cate->lastPage())
                      <li><a href="{!! str_replace('/?','?',$product_cate->url($product_cate->currentPage()+1)) !!}">Next</a>
                      @endif
                      </li>
                    </ul>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
@endsection()

