@include('index_header')

                <section class="col-xs-12 section1">
                    <div class="container">
                        <div class="jumbotron jumbotron-sm">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <h1 class="h1">
                                            Contact us <small>Feel free to contact us</small></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-xs-12">
                                    <div class="well well-sm panel-heading">

        @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
        @endif
        @if (Session::has('message-err'))
        <div class="alert alert-danger">{{ Session::get('message-err') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
        @endif

                                    <form method="post" id="contactus" action="dealercontactus">
                                            <div class="row">
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="fullname">
                                                            Full Name</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name" required="required" /></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dealername">
                                                            Dealer Name</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                                            </span>
                                                            <input type="text" class="form-control" id="dealername" name="dealername" placeholder="Enter Dealer Name" required="required" /></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phone">
                                                            Phone Number</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i>
                                                            </span>
                                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" required="required" /></div>
                                                    </div>

                                                    <div class="form-group">
                                                    <label for="req_type">Request Type</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-share" aria-hidden="true"></i>
                                                    </span>
                                                    <select class="form-control" name="req_type">
                                                        <option selected="true" disabled="disabled">Select Request Type</option>
                                                        <option value="General">General</option>
                                                        <option value="Product Demo">Product Demo</option>
                                                        <option value="Technical Query">Technical Query</option>
                                                        <option value="Financing Assistance">Financing Assistance</option>
                                                    </select>
                                                    </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 col-xs-12">

                                                    <div class="form-group">
                                                        <label for="email">
                                                            Email Address</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                                            </span>
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required="required" /></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">
                                                            Message</label>
                                                        <textarea name="message" name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                                                  placeholder="Message"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                                                        Send Message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <form>
                                        <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
                                        <address>
                                            <strong>Company Name</strong><br>
                                            addresss<br>
                                            addresss<br>
                                            phone
                                        </address>
                                        <address>
                                            <strong>Full Name</strong><br>
                                            <a href="mailto:#">first.last@example.com</a>
                                        </address>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <footer class="col-xs-12">
                        <div class="row dash-footer">

                            <!--<div class="hr-dashed"></div>-->
                            <div class="col-xs-12 col-lg-8 col-md-9 col-sm-9 park-diva">
                                <div class="col-sm-3 col-xs-12">
                                    <h5><b>Overview</b></h5>
                                    <p><a href="about.html">About</a></p>
                                    <p><a href="feedback.html">Feedback</a></p>
                                    <p><a href="contactus.html">Contact Us</a></p>
                                    <p><a href="faqs.html">FAQs</a></p>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <h5><b>Service</b></h5>
                                    <p><a href="advertise.html">Advertise</a></p>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <h5><b>Others</b></h5>
                                    <p><a href="privacy_policy.html">Privacy Policy</a></p>
                                    <p><a href="terms_conditions.html">Terms And Conditions</a></p>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <h5><b>Feel free to contact us</b></h5>
                                    <p><a href=""><i class="fa fa-phone"></i> 987654321</a></p>
                                    <p><a href="">Support@dealerplus.in</a></p>

                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-4 col-md-3 col-sm-3 downloadsec">
                                <div class="col-xs-12">    
                                    <h5><a href=""><i class="fa fa-download" aria-hidden="true"></i> Download Dealer Plus Mobile App</a></h5>
                                </div>
                                <div class="col-xs-12  footerlogo"><a href=""><img src="img/google_play2.png" class="img-responsive"/></a></div>
                                <div class="col-xs-12  footerlogo"><a href=""><img src="img/app_store2.png" class="img-responsive"/></a></div>
                            </div>
                            <!--<div class="col-xs-12 hr-dashed"></div>-->
                            <div class="col-xs-12 lastfooter">
                                <div class="col-sm-8 col-xs-12"> <em>Copyright &copy; <a href="#"> 2016 Dealer Plus</a></em></div>
                                <div class="col-sm-4 col-xs-12">  <ul class="social-network social-circle pull-right col-xs-12">
                                        <!--<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>-->
                                        <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <!--<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>-->
                                        <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    </ul></div>

                            </div>
                      
                    </div>
                </footer>
            </div>
        </div>
    
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.form-validator.min.js"></script>
<script src="js/dealerplus.js"></script>
<script src="js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="js/label-slide.js" type="text/javascript"></script>
<script type='text/javascript'>

jQuery(document).ready(function (){

    /*$("#btnContactUs").click(function(e){
            alert("sdfsfsdf")
    });
*/

});

</body>
</html>
