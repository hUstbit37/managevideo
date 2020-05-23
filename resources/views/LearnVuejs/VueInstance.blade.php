<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study VueJs</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_vuejs1.css') }}">
</head>
<body>
    <!-- <header><h1>Lazadell</h1></header> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Lazadell</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Product</a>
      </li>

      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
    <div class='container'>
        <div class="list-blog">
            <p>Áo thun Adidas thể thao nam nhiều màu 100% đạt chuẩn xuất khẩu đi các nước châu Âu. Áo thun Adidas thể thao nam nhiều màu 100% đạt chuẩn xuất khẩu đi các nước châu Âu.</p>
        </div>

        <div id="app">
            <div class="cart">Giỏ hàng (@{{cartNumber}})</div>
            <div class="product">
                <div class="product-image">
                    <div class="image">
                        <img v-bind:src="getSelectedProduct.image" alt="">
                        <!-- <img src="{{ asset('img/1.jpg') }}" alt="" srcset=""> -->
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="title">
                    <a v-bind:href="url" v-bind:target="target">@{{title}}</a>
                    </h3>
                    <p class="brand">Thương hiệu: Nike</p>
                    <p class="quantity" v-if="getSelectedProduct.quantity > 0" >Còn lại: @{{ getSelectedProduct.quantity }} sản phẩm</p>
                    <p class="quantity" v-if="getSelectedProduct.quantity <= 0">Sản phẩm đã hết hàng</p>

                    <div class="wrapper-price">
                        <div class="final-price">@{{formatFinalPrice}}</div>
                        <div class="origin-price">@{{formatOriginalPrice}}</div>
                        <div class="sale-price">-@{{sale * 100}}%</div>
                    </div>
                    <div class="wrapper-color">
                        <div class="text">Màu sắc</div>
                        <div class="list-color">
                            <p class="color-text">@{{getSelectedProduct.textColor}}</p>
                            <ul>
                                <!-- class active ở đây để tạo hover-css khi click vào  -->
                                <!-- <li
                                    v-bind:class="{active: selectedProduct == index}"
                                    v-for="(item, index) in listProductDetail"
                                    v-on:click="handleClickColor($event, index)">
                                    <img v-bind:src="item.image" v-bind:alt="item.textColor">
                                </li> -->
                                <li
                                    v-for="(item, index) in listProductDetail"
                                    v-bind:class="classColorActive(index)"
                                    v-bind:key="index"
                                    v-on:click="handleClickColor($event, index)">
                                    <img v-bind:src="item.image" v-bind:alt="item.textColor">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button
                        v-on:click="handleAddCart"
                        class="add-to-cart">
                        Add to cart
                    </button>
                </div>
            </div>
            <div class="description">
                <h2>Mô tả chi tiết&nbsp;</h2>
                <ul class="extra-info">
                    <li v-for="item in listDescription">@{{ item }}</li>
                </ul>
                <!-- v-html -->
                <div v-html="testDescription"></div>
            </div>

        </div>
    </div>

    <footer><div>&copy2020 by Duc</div></footer>
</body>
<!-- <script src="../js/vuejs1.js"></script> -->
<script src="{{ asset('js/vuejs1.js') }}"></script>
</html>
