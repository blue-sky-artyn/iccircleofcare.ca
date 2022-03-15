<%@ Page Title="" Language="C#" MasterPageFile="~/footer.master" AutoEventWireup="true" CodeFile="contact.aspx.cs" Inherits="contact" %>

<asp:Content ID="Content1" ContentPlaceHolderID="contentPlaceFooterHead" Runat="Server">
    <style>
        .font-awsome-icon {
            font-size: 20px;
            display: inline-block;
            margin: 0 5px;
        }
        .facebook {color: blue}
        a {}
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="contentPlaceFooterBody" Runat="Server">
    <section class="top-title-others section lb p120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tagline-message page-title text-center">
                        <h3 id="titleBigHtml" runat="server">Contact Us</h3>
                        <ul class="breadcrumb">
                            <li><a href="default.aspx">Home</a></li>
                            <li id="titleSmallHtml" runat="server" class="active">contact us</li>
                        </ul>
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
            <div class="container">
                <div class="boxed boxedp4">

                    <div id="map" class="wow slideInUp">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1386.024798905801!2d-79.43412075170318!3d43.88913656537117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b2bb8e0c8e3e7%3A0xba6731404520e057!2sDecowall%20inc!5e0!3m2!1sen!2sca!4v1591673797228!5m2!1sen!2sca" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>

                    <div class="row contactv2 text-center">
                        <div class="col-md-4">
                            <div class="small-box">
                                <i class="flaticon-email wow fadeIn"></i>
                                <h4>Contact Details</h4>
                                <div id="contactDetHtml" runat="server">
                                    <small>Phone: +90 987 665 55 44</small>
                                    <small>Fax:  +90 987 665 55 45</small>
                                    <p><a href="mail:to">info@yoursite.com</a></p>
                                </div>
                            </div><!-- end small-box -->
                        </div><!-- end col -->

                        <div class="col-md-4">
                            <div class="small-box">
                                <i class="flaticon-map-with-position-marker wow fadeIn"></i>
                                <h4>Address</h4>
                                <div id="contactAddrHtml" runat="server">                                
                                <small>PO Box 16122 Collins Street West</small>
                                <small>Victoria 8007 Australia</small>
                                <p><a href="#">View on Google Map</a></p>
                                    </div>
                            </div><!-- end small-box -->
                        </div><!-- end col -->

                        <div class="col-md-4">
                            <div class="small-box">
                                <i class="flaticon-share wow fadeIn"></i>
                                <h4>Keep in touch</h4>
                                <div id="socialLinkHtml" runat="server">   

                                <small>Twitter: @yourhandle</small>
                                <small>Facebook: facebook.com/yourhandle</small>
                                <p><a href="#">Email Newsletter</a></p>
                                </div>
                            </div><!-- end small-box -->
                        </div><!-- end col -->
                    </div><!-- end contactv2 -->

                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="section-title text-center">
                                <h3>Contact Form</h3>
                                <p>Maecenas sit amet tristique turpis. Quisque porttitor eros quis leo pulvinar, at hendrerit sapien iaculis.</p>
                            </div><!-- end title -->
                            
                            <div class="big-contact-form" role="search">
                                <input type="text" class="form-control" placeholder="Enter your name..">
                                <input type="email" class="form-control" placeholder="Enter email..">
                                <input type="text" class="form-control" placeholder="Your phone..">
                                <input type="text" class="form-control" placeholder="Subject..">
                                <textarea class="form-control" placeholder="Message goes here.."></textarea>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end container -->
            </div>
        </section>
    <!-- jQuery Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>
</asp:Content>

