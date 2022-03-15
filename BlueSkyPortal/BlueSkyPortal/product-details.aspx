<%@ Page Title="" Language="C#" MasterPageFile="~/footer.master" AutoEventWireup="true" CodeFile="product-details.aspx.cs" Inherits="Default2" %>

<asp:Content ID="Content1" ContentPlaceHolderID="contentPlaceFooterHead" Runat="Server">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/prettyPhoto.css">

    <style>
        .sub-pic-row {margin-bottom: 15px;}
        .unique-item {font-size: 10px;}
    </style>

</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="contentPlaceFooterBody" Runat="Server">
            
    <section class="top-title-others section lb p120">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tagline-message page-title text-center">
                            <h3 id="titleBigHtml" runat="server">Shopping</h3>
                            <ul class="breadcrumb">
                                <li><a href="javascript:void(0)">Home</a></li>
                                <li id="titleSmallHtml" runat="server" class="active">Shop</li>
                                <li id="titleSmall2Html" runat="server" class="active"></li>
                            </ul>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end section -->

      <section class="section">
            <div class="container">
                <div class=" ">
                    <div class="row">
                        <div class="col-md-6 shop-media">
                            <div class="row">
                                <div class="col-md-12">
                                <div id="mainPicHtml" runat="server" class="image-wrap entry">
                                    <img src="upload/single_shop_01.jpg" alt="" class="img-responsive">
                                    <div class="magnifier">
                                        <a rel="prettyPhoto[inline]" href="upload/single_shop_01.jpg" title=""><i class="flaticon-add"></i></a>
                                    </div>
                                </div><!-- end image-wrap -->
                                </div>
                            </div><!-- end row -->

                           <hr class="invis" />

                            <div id="productSubPicHtml" runat="server">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="image-wrap entry">
                                        <img src="upload/single_shop_02.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_02.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="image-wrap entry">
                                        <img src="upload/single_shop_02.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_02.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="image-wrap entry">
                                        <img src="upload/single_shop_03.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_03.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>
                                </div>
                            <div class="row-space row">

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="image-wrap entry">
                                        <img src="upload/single_shop_04.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_04.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>
                            </div><!-- end row -->
                                </div>
                        </div><!-- end col -->

                        <div class="col-md-6">
                            <div class="shop-desc">
                                <%--<h3 id="productTitleHtml" runat="server">Brown leather bag</h3>--%>
                                <div id="productDetailsHtml" runat="server">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis consequat condimentum. In a tincidunt purus. Curabitur facilisis luctus aliquet. Aenean a cursus erat, sit amet interdum arcu. Mauris aliquam magna turpis, lobortis pellentesque velit elementum et. Nulla scelerisque a lorem nec posuere. Nunc convallis posuere tincidunt. Pellentesque a aliquet odio. Integer euismod, enim id lacinia auctor, tortor turpis malesuada enim, in semper turpis magna quis enim.</div>
                                <small id="ProductPriceHtml" runat="server">$20.00</small>
                                <%--<div class="shop-meta">
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                    <ul class="list-inline">
                                        <li> SKU: product-111</li>
                                        <li>Categories: <a href="#">Bags</a>
                                    </ul>
                                </div><!-- end shop meta -->--%>
                            </div><!-- end desc -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <hr class="invis">

                    <div class="row">   
                        <div class="col-md-12">
                            <div class="shop-extra">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">Description</a></li>
                                    <li><a data-toggle="tab" href="#menu1">Additional information</a></li>
                                    <li><a data-toggle="tab" href="#menu2">Reviews (2)</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" ClientIDMode="static" runat="server" class="tab-pane fade in active">
                                        <p>Suspendisse tristique porttitor magna, ac pulvinar libero lobortis at. Quisque sit amet facilisis eros. Vestibulum id ligula elementum, rutrum nunc sit amet, vulputate diam. Phasellus finibus mauris leo, quis commodo elit pellentesque quis. Phasellus a justo in enim maximus dictum nec interdum erat. Integer varius justo id nunc vulputate scelerisque. Curabitur maximus tristique magna. Nulla ut laoreet turpis, vel porta mauris. Suspendisse et varius orci, eget ullamcorper lacus. Duis accumsan odio at elit facilisis semper.</p>

                                        <p>Phasellus finibus mauris leo, quis commodo elit pellentesque quis. Phasellus a justo in enim maximus dictum nec interdum erat. Integer varius justo id nunc vulputate scelerisque. Curabitur maximus tristique magna. Nulla ut laoreet turpis, vel porta mauris. Suspendisse et varius orci, eget ullamcorper lacus. Duis accumsan odio at elit facilisis semper.</p>
                                    </div>
                                    <div id="menu1" ClientIDMode="static" runat="server" class="tab-pane fade">
                                        <h3>Technical details</h3>
                                        <table class="table">
                                            <tbody id="techDetHtml" runat="server">
                                                <tr>
                                                    <td><strong>Weight</strong></td>
                                                    <td>4.5 kg</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Colors</strong></td>
                                                    <td>Brown, Black</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Size</strong></td>
                                                    <td>50cm x 30cm</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu2" ClientIDMode="static" runat="server" class="tab-pane fade">
                                        <h3>Reviews</h3>

                                        <p>Base on customers' review</p>

                                        <div class="rating">
                                            <span>product review:</span>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>

                                    </div>
                                </div>
                            </div><!-- end shop-extra -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <hr class="invis">

                    <div class="related-products">
                        <div class="text-widget">
                            <h3>Related Products</h3>
                        </div><!-- end title -->        

                        <div id="relatedProductHtml" runat="server" class="row blog-grid shop-grid">
                            <div class="col-md-3">
                                <div class="course-box shop-wrapper">
                                    <div class="image-wrap entry">
                                        <img src="upload/shop_01.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a href="shop-single.html" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div>
                                    <!-- end image-wrap -->
                                    <div class="course-details shop-box text-center">
                                        <h4>
                                            <a href="shop-single.html" title="">Brown leather bag</a>
                                            <small>Bags</small>
                                        </h4>
                                    </div>
                                    <!-- end details -->
                                    <div class="course-footer clearfix">
                                        <div class="pull-left">
                                            <ul class="list-inline">
                                                <li><a href="#"><i class="fa fa-shopping-basket"></i> Add Cart</a></li>
                                            </ul>
                                        </div><!-- end left -->

                                        <div class="pull-right">
                                            <ul class="list-inline">
                                                <li><a href="#">$441.00</a></li>
                                            </ul>
                                        </div><!-- end left -->
                                    </div><!-- end footer -->
                                </div><!-- end box -->
                            </div><!-- end col -->

                            <div class="col-md-3">
                                <div class="course-box shop-wrapper">
                                    <div class="image-wrap entry">
                                        <img src="upload/shop_02.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a href="shop-single.html" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div>
                                    <!-- end image-wrap -->
                                    <div class="course-details shop-box text-center">
                                        <h4>
                                            <a href="shop-single.html" title="">Long coat jacket</a>
                                            <small>Jackets</small>
                                        </h4>
                                    </div>
                                    <!-- end details -->
                                    <div class="course-footer clearfix">
                                        <div class="pull-left">
                                            <ul class="list-inline">
                                                <li><a href="#"><i class="fa fa-shopping-basket"></i> Add Cart</a></li>
                                            </ul>
                                        </div><!-- end left -->

                                        <div class="pull-right">
                                            <ul class="list-inline">
                                                <li><a href="#">$122.00</a></li>
                                            </ul>
                                        </div><!-- end left -->
                                    </div><!-- end footer -->
                                </div><!-- end box -->
                            </div><!-- end col -->

                            <div class="col-md-3">
                                <div class="course-box shop-wrapper">
                                    <div class="image-wrap entry">
                                        <img src="upload/shop_03.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a href="shop-single.html" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div>
                                    <!-- end image-wrap -->
                                    <div class="course-details shop-box text-center">
                                        <h4>
                                            <a href="shop-single.html" title="">Style own glasses</a>
                                            <small>Glasses</small>
                                        </h4>
                                    </div>
                                    <!-- end details -->
                                    <div class="course-footer clearfix">
                                        <div class="pull-left">
                                            <ul class="list-inline">
                                                <li><a href="#"><i class="fa fa-shopping-basket"></i> Add Cart</a></li>
                                            </ul>
                                        </div><!-- end left -->

                                        <div class="pull-right">
                                            <ul class="list-inline">
                                                <li><a href="#">$52.00</a></li>
                                            </ul>
                                        </div><!-- end left -->
                                    </div><!-- end footer -->
                                </div><!-- end box -->
                            </div><!-- end col -->

                            <div class="col-md-3">
                                <div class="course-box shop-wrapper">
                                    <div class="image-wrap entry">
                                        <img src="upload/shop_04.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a href="shop-single.html" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div>
                                    <!-- end image-wrap -->
                                    <div class="course-details shop-box text-center">
                                        <h4>
                                            <a href="shop-single.html" title="">Printed white t-shirt</a>
                                            <small>T-Shirts</small>
                                        </h4>
                                    </div>
                                    <!-- end details -->
                                    <div class="course-footer clearfix">
                                        <div class="pull-left">
                                            <ul class="list-inline">
                                                <li><a href="#"><i class="fa fa-shopping-basket"></i> Add Cart</a></li>
                                            </ul>
                                        </div><!-- end left -->

                                        <div class="pull-right">
                                            <ul class="list-inline">
                                                <li><a href="#">$22.00</a></li>
                                            </ul>
                                        </div><!-- end left -->
                                    </div><!-- end footer -->
                                </div><!-- end box -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end related -->
                </div><!-- end boxed -->
            </div><!-- end container -->
        </section>
</div>
<!-- jQuery Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
</asp:Content>

