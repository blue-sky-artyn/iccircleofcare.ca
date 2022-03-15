<%@ Page Title="" Language="C#" MasterPageFile="~/footer.master" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="_Default" %>

<asp:Content ID="Content1" ContentPlaceHolderID="contentPlaceFooterHead" Runat="Server">
    <style>
        /* Slider Start */
        .accordion {
            width: 100%;
            /*height: 350px;*/
            overflow: hidden;
            margin: 0px auto;
        }

            .accordion ul {
                width: 100%;
                height: 100%;
                display: table;
                table-layout: fixed;
                margin: 0;
                padding: 0;
            }

                .accordion ul li {
                    display: table-cell;
                    vertical-align: bottom;
                    position: relative;
                    width: 16.666%;
                    height: 350px;
                    background-repeat: no-repeat;
                    background-position: center center;
                    transition: all 500ms ease-in-out;
                }

                    .accordion ul li div {
                        display: block;
                        overflow: hidden;
                        width: 100%;
                    }

                        .accordion ul li div a {
                            display: block;
                            height: 350px;
                            width: 100%;
                            position: relative;
                            z-index: 3;
                            vertical-align: bottom;
                            padding: 15px 20px;
                            box-sizing: border-box;
                            color: #fff;
                            text-shadow: 1px 1px 2px #000;
                            /*filter: invert(100%);*/
                            text-decoration: none;
                            font-family: Open Sans, sans-serif;
                            transition: all 300ms ease-in-out;
                        }

                            .accordion ul li div a * {
                                opacity: 0;
                                margin: 0;
                                width: 100%;
                                text-overflow: ellipsis;
                                position: relative;
                                z-index: 5;
                                white-space: nowrap;
                                overflow: hidden;
                                -webkit-transform: translateX(-20px);
                                transform: translateX(-20px);
                                -webkit-transition: all 400ms ease-in-out;
                                transition: all 400ms ease-in-out;
                            }

                            .accordion ul li div a h2 {
                                font-family: Montserrat, sans-serif;
                                text-overflow: clip;
                                font-size: 32px;
                                text-transform: uppercase;
                                margin-bottom: 2px;
                                top: 160px;
                            }

                            .accordion ul li div a p {
                                top: 160px;
                                font-size: 18px;
                                padding-left: 1em;
                            }


                .accordion ul li {
                    background-size: cover;
                }

                .accordion ul:hover li {
                    width: 10%;
                }

                    .accordion ul:hover li:hover {
                        width: 90%;
                    }

                        /*.accordion ul:hover li:hover a { background: rgba(0, 0, 0, 0.4); }*/

                        .accordion ul:hover li:hover a * {
                            opacity: 1;
                            -webkit-transform: translateX(0);
                            transform: translateX(0);
                        }

        @media screen and (max-width: 680px) {

            .accordion {
                height: auto;
            }

                .accordion ul li,
                .accordion ul li:hover,
                .accordion ul:hover li,
                .accordion ul:hover li:hover {
                    position: relative;
                    display: table;
                    table-layout: fixed;
                    width: 100%;
                    -webkit-transition: none;
                    transition: none;
                }

                    .accordion ul li div a * {
                        opacity: 1;
                        -webkit-transform: translateX(0);
                        transform: translateX(0);
                    }
        }
        /* slider end */
        /* parallax */
        .parallax-bg {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: 1;
        }

            .parallax-bg img {
                width: 100%;
                position: relative;
                bottom: 15%;
            }
        /* spacer */
        .section-spacer {
            overflow: hidden;
            height: 320px;
            background-size: cover;
            background-position: 0px 100%;
            background-repeat: no-repeat;
        }



        .testiname {
            text-align: center;
            width: 36.5%;
            margin: 0 auto 2.5em;
        }

        .big-title {
            font-size: 3.000em !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: -0.025em;
            font-family: "Open Sans",sans-serif;
            color: #333333;
        }

        .info-img-box {
            width: 100%;
        }

        .info-img-box img {
            width: 100%;
        }

        .bg-big {
            background-color:green;
            background-image: url("./images/bg-big.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .title-color {color: white !important;}
        .section-content {
                margin-top: 10rem;
        }
    </style>

    <link rel="stylesheet" href="css/carousel.css">

    <!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />
	<script type="text/javascript" src="engine1/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->


</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="contentPlaceFooterBody" Runat="Server">
    <%-- Accordion Slider --%>
    <section class="accordion video-section js-height-full">

        <!-- Start slider -->
        <div id="wowslider-container1">
            <div class="ws_images">
                <ul id="sliderItemsHtml" runat="server">
                    <li>
                        <img src="images/slider/1.jpg" alt="1" title="IC circle of care organization" id="wows1_0" /></li>
                    <li>
                        <img src="images/slider/2.jpg" alt="2" title="IC circle of care organization" id="wows1_1" /></li>
                    <li>
                        <img src="images/slider/3.jpg" alt="3" title="IC circle of care organization" id="wows1_2" /></li>
                    <li>
                        <img src="images/slider/4.jpg" alt="4" title="IC circle of care organization" id="wows1_3" /></li>
                </ul>
            </div>
            <div class="ws_shadow"></div>
        </div>
        <script type="text/javascript" src="engine1/wowslider.js"></script>
        <script type="text/javascript" src="engine1/script.js"></script>
        <!-- End slider -->


        <div class="slider-bottom">
            <span>Explore <i class="fa fa-angle-down"></i></span>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 hidden-sm hidden-xs">
                    <div class="custom-module">
                        <img id="honorPicHtml" runat="server" src="images/img1.jpg" alt="" class="img-responsive wow slideInLeft">
                    </div>
                    <!-- end module -->
                </div>
                <!-- end col -->
                <div class="col-md-8">
                    <div id="aboutCompanyHtml" runat="server" class="custom-module p40l">
                        <h2>A brief about <mark>IC Circle of Care</mark> activities <br>
                            </h2>

                        <p>Nam dictum sem, ipsum aliquam . Etiam sit amet fringilla lacus. Pellentesque suscipit ante at ullamcorper pulvinar neque porttitor. Integer lectus. Praesent sed nisi eleifend, fermentum orci amet, iaculis libero.</p>

                        <hr class="invis">

                        <div class="btn-wrapper">
                            <a href="about.aspx" class="btn btn-primary">Find out more</a>
                        </div>

                    </div>
                    <!-- end module -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    
    <section class="section">
        <div class="container">
            <div class="section-title text-center">
                <h3 class="big-title">Our Mission</h3>
                <p>Protecting the rights and wellbeing of EVERY child</p>
            </div>
            <!-- end title -->

            <div class="row" id="servicesHtml" runat="server">
                <div class="col-md-4">
                    <div class="box testimonial">
                        <div class="testiname">
                            <img src="images/icon1.png" alt="icon1" />
                        </div>
                        <p>Promoting the right and wellbeing of every child, in everything we do.</p>
                       
                    </div>
                    <!-- end testimonial -->
                </div>
                <!-- end col -->

                <div class="col-md-4">
                    <div class="box testimonial">
                        <div class="testiname">
                            <img src="images/icon2.png" alt="icon2" />
                        </div>
                        <p>Supporting Hope programs for children in more than 150 countries and territories.</p>
                       
                    </div>
                    <!-- end testimonial -->
                </div>
                <!-- end col -->

                <div class="col-md-4">
                    <div class="box testimonial">
                        <div class="testiname">
                            <img src="images/icon3.png" alt="icon3" />
                        </div>
                        <p>Focus on reaching the most vunerable children, to benefit all children, everywhere.</p>
                       
                    </div>
                    <!-- end testimonial -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <section id="sectionInfoHtml" runat="server" class="section db p120" style="background-image: url(images/bg1.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tagline-message text-center">
                        <h3>Information that may work</h3>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end section -->
    
    <section class="section gb nopadtop">
        <div id="inforamtionHtml" runat="server" class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="box m30">
                        <div class="info-img-box"><img src="images/news/1.jpg" alt="info 1" /></div>
                        <h4>Clean Water For People</h4>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        <a href="#" class="readmore">Read more</a>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-md-6">
                    <div class="box m30">
                        <div class="info-img-box"><img src="images/news/2.png" alt="info 2" /></div>
                        <h4>Education for Everyone</h4>
                        <p>qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
                        <a href="#" class="readmore">Read more</a>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-md-3">
                    <div class="box m30">
                        <div class="info-img-box"><img src="images/news/3.jpg" alt="info 3" /></div>
                        <h4>Sponsor Ecology Today</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <a href="#" class="readmore">Read more</a>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <hr class="invis">

            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="info-img-box"><img src="images/news/4.jpg" alt="info 4" /></div>
                        <h4>Clean Water For People</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <a href="#" class="readmore">Read more</a>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-md-6">
                    <div class="box">
                        <div class="info-img-box"><img src="images/news/5.jpg" alt="info 5" /></div>
                        <h4>Education for Everyone</h4>
                        <p>et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,</p>
                        <a href="#" class="readmore">Read more</a>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <section class="section db">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="stat-count">
                        <h4 class="stat-timer">1230</h4>
                        <h3><i class="fa fa-handshake-o" aria-hidden="true"></i>Numbers of Volunteers</h3>
                        <p>Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. </p>
                    </div>
                    <!-- stat-count -->
                </div>
                <!-- end col -->

                <div class="col-lg-4 col-md-4">
                    <div class="stat-count">
                        <h4 class="stat-timer">331</h4>
                        <h3><i class="fa fa-globe" aria-hidden="true"></i>Number of Projects</h3>
                        <p>Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. </p>
                    </div>
                    <!-- stat-count -->
                </div>
                <!-- end col -->

                <div class="col-lg-4 col-md-4">
                    <div class="stat-count">
                        <h4 class="stat-timer">8901</h4>
                        <h3><i class="fa fa-hourglass-start" aria-hidden="true"></i>Numbers of Volunteer Hours</h3>
                        <p>Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. </p>
                    </div>
                    <!-- stat-count -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <section class="bg-big accordion video-section js-height-full">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-4 js-height-full">
                    <div class="section-content section-title">
                        <h2 class="title-color big-title">HELP CINDY
                            <br />
                            GET<br />
                            BACK TO<br />
                            SCHOOL</h2>
                    </div>
                    <div class="articlle">
                        <p class="title-color">Pellentesque lacinia urna eget luctus faucibus. Sus pendisse potenti. Morbi accumsan, arcu et feugiat hen drerit, odio quam egestas risus, tincidunt gravida estrisus ut enim.</p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>

    <section class="section gb">
        <div class="container">
            <div class="section-title text-center">
                <h3>Recent News</h3>
                <%--<p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis. Donec consectetur accumsan arcu, sit amet fringilla ex ultricies.</p>--%>
            </div>
            <!-- end title -->
            <div id="newsDetHtml" runat="server">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="blog-box">
                            <div class="">
                                <img src="images/product/4.jpg" alt="" class="img-responsive">
                                <div class="magnifier">
                                    <a href="#" title=""><i class="flaticon-add"></i></a>
                                </div>
                            </div>
                            <!-- end image-wrap -->

                            <div class="blog-desc">
                                <h4><a href="#">Local 27 brotherhood showcased during member’s time of need</a></h4>
                                <p>When Dave Pynn, a 40-year member of the Carpenters’ Union Local 27, took a fall on a hunting trip last November, sustaining a paralyzing injury, it might not have occurred to him that members of the union would come to bat for him.</p>
                            </div>
                            <!-- end blog-desc -->

                            <div class="post-meta">
                                <ul class="list-inline">
                                    <li><a href="#">21 March 2017</a></li>
                                    <li><a href="#">by Admin</a></li>
                                </ul>
                            </div>
                            <!-- end post-meta -->
                        </div>
                        <!-- end blog -->
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4 col-md-12">
                        <div class="blog-box">
                            <div class="">
                                <img src="images/product/2.jpg" alt="" class="img-responsive">
                                <div class="magnifier">
                                    <a href="#" title=""><i class="flaticon-add"></i></a>
                                </div>
                            </div>
                            <!-- end image-wrap -->

                            <div class="blog-desc">
                                <h4><a href="#">LIUNA solicits McKenna’s support for Hamilton LRT</a></h4>
                                <p>Top LIUNA executive Joe Mancinelli has told Minister of Infrastructure and Communities Catherine McKenna that the federal government should support shovel-ready projects like Hamilton’s proposed LRT build as it prepares plans to kick-start the national economy into a post-COVID-19 recovery.</p>
                            </div>
                            <!-- end blog-desc -->

                            <div class="post-meta">
                                <ul class="list-inline">
                                    <li><a href="#">20 March 2017</a></li>
                                    <li><a href="#">by Admin</a></li>
                                </ul>
                            </div>
                            <!-- end post-meta -->
                        </div>
                        <!-- end blog -->
                    </div>
                    <!-- end col -->

                    <div class="col-lg-4 col-md-12">
                        <div class="blog-box">
                            <div class="">
                                <img src="images/product/3.jpg" alt="" class="img-responsive">
                                <div class="magnifier">
                                    <a href="#" title=""><i class="flaticon-add"></i></a>
                                </div>
                            </div>
                            <!-- end image-wrap -->

                            <div class="blog-desc">
                                <h4><a href="#">Construction unions urge rigid adherence to safety protocol</a></h4>
                                <p>MONTREAL — Two leading Quebec construction trade unions are saying they will monitor health and safety at jobsites closely when construction resumes at residential sites April 20.</p>
                            </div>
                            <!-- end blog-desc -->

                            <div class="post-meta">
                                <ul class="list-inline">
                                    <li><a href="#">19 March 2017</a></li>
                                    <li><a href="#">by Admin</a></li>
                                </ul>
                            </div>
                            <!-- end post-meta -->
                        </div>
                        <!-- end blog -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <section class="section bgcolor1">
        <div id="popUpHtml" runat="server" class="container">
            <a href="#">
                <div class="row callout">
                    <div class="col-md-4 text-center">
                        <h3><sup>$</sup>49.99</h3>
                        <h4>Call to make arragment and get discount right now!</h4>
                    </div>
                    <!-- end col -->

                    <div class="col-md-8">
                        <p class="lead">Limited time offer! Take discount for the first customers</p>
                    </div>
                </div>
                <!-- end row -->
            </a>
        </div>
        <!-- end container -->
    </section>

    <!-- jQuery Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>

</asp:Content>

