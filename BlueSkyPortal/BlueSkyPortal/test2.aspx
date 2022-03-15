<%@ Page Title="" Language="C#" MasterPageFile="~/Master.master" AutoEventWireup="true" CodeFile="test2.aspx.cs" Inherits="test2" %>

<asp:Content ID="Content1" ContentPlaceHolderID="Materhead" Runat="Server">
    <link rel="stylesheet" href="css/prettyPhoto.css">
</asp:Content>


<asp:Content ID="Content2" ContentPlaceHolderID="MainMasterContent" Runat="Server">
    <div id="wrapper">
    <section class="section">
            <div class="container">
                <div class=" ">
                    <div class="row">
                        <div class="col-md-6 shop-media">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="image-wrap entry">
                                    <img src="upload/single_shop_01.jpg" alt="" class="img-responsive">
                                    <div class="magnifier">
                                        <a rel="prettyPhoto[inline]" href="upload/single_shop_01.jpg" title=""><i class="flaticon-add"></i></a>
                                    </div>
                                </div><!-- end image-wrap -->
                                </div>
                            </div><!-- end row -->

                            <hr class="invis">

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
                                        <img src="upload/single_shop_03.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_03.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="image-wrap entry">
                                        <img src="upload/single_shop_04.jpg" alt="" class="img-responsive">
                                        <div class="magnifier">
                                            <a rel="prettyPhoto[inline]" href="upload/single_shop_04.jpg" title=""><i class="flaticon-add"></i></a>
                                        </div>
                                    </div><!-- end image-wrap -->
                                </div>
                            </div><!-- end row -->
                        </div><!-- end col -->

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
</asp:Content>

