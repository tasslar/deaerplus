@include('index_header')
<section class="col-xs-12 bannerguest">
    <div class="row">
        <div class="col-xs-12 guestbanner">
            <div class="row guestbannerlayer">
                <div class="col-xs-12 col-xs-12 aboutbanner_content">
                    <div class="about_bannerh1">
                        <div class="homeh1">
                            <h1>We Care Your Business</h1>
                            <a href="<?= URL::to('/login') ?>" class="signin">Sign In</a>
                            <a href="<?= URL::to('/dealerregistration') ?>" class="signup">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<section class="col-xs-12 section1">
    <div class="container">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="row">
                <div class="col-xs-12 icons"><i class="fa fa-taxi" aria-hidden="true"></i><span class="glyphicon glyphicon-car"></span></div>             
                <div class="col-xs-12 text-center"><h3>Add & Manage Inventory</h3>
                    <b>Adding/Managing cars has never been this easy!</b>
                    <p>Our highly advanced integrated inventory system now makes adding cars easy and less tiring, gone are the days of troublesome list generation and management, now say “Hi” to our easy to use inventory system where you can add & manage your list of cars on the fly.</p>             
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 ">
            <div class="row">
                <div class="col-xs-12 icons"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>             
                <div class="col-xs-12 text-center"><h3>Build Dealership Website</h3>
                    <b>Create your own website in just a few clicks!</b>
                    <p>Want build your own website? But are you afraid that you have to manually integrate a DMS system? Look no further, because we got it covered for you! Now with our built in “create your own website” system you can create/manage your own online marketplace!</p>             
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 ">
            <div class="row">
                <div class="col-xs-12 icons"><i class="fa fa-users" aria-hidden="true"></i></div>             
                <div class="col-xs-12 text-center"><h3>Lead Management</h3>
                    <b>Now manage leads on the fly!</b>
                    <p>All those enquiries and clicks on your advertisement postings make a good list of potential buyers of your cars, but wait… how do you keep a record of them and manage those valuable sale leads? The good news is that we got it covered for you, as our integrated lead management system gathers all the information you need and keeps a record for your access anytime!</p>             
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 ">
            <div class="row">
                <div class="col-xs-12 icons"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>             
                <div class="col-xs-12 text-center"><h3>Publish to Marketplaces</h3>
                    <b>All it takes is one click now!</b>
                    <p>Tired of retyping/entering the same advertisement on multiple website? What if we tell you uploading your stock in our system will get your posts on several of other websites/portals, yes you heard it right – just upload your stock once and all it takes is a single click for your advertisement to be posted on all the other websites/platforms you can think of!</p>             
                </div>
            </div>
        </div>
    </div>
</section>
<section class="col-xs-12 section2">
    <div class="container">
        <div class="col-sm-6 col-xs-12 section2img">
            <img src="img/Library.png" alt="technology image"/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h2>The Technology</h2>
            <h3>Ground breaking solution built for you!</h3>
            <p>We have made your job simple with our DMS system, using our ground breaking innovative and creative ideas we have made a system that will ease your job by keeping track of all your cars with its one point data entry system. It couldn’t be any easier to create a used car record on the system, just use our tool to populate the required fields. Once the data has been entered all you need to do is advertise it on all possible platforms across the vast sea of internet buy just clicking once and letting our system take care of the postings for you!</p>             
        </div>
    </div>
</section>
<section class="col-xs-12 section3">
    <div class="container">
        <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                <li role="presentation" class="active">
                    <a href="#divnew" role="tab" data-toggle="tab" aria-controls="div1" aria-expanded="true">
                        <span class="text">Funding Solution</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#div1" role="tab" data-toggle="tab" aria-controls="div1" aria-expanded="true">
                        <span class="text">Inventory Management</span>
                    </a>
                </li>
                <li role="presentation" class="next">
                    <a href="#div2" role="tab"  data-toggle="tab" aria-controls="div2">
                        <span class="text">Mobile friendly</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#div3" role="tab"  data-toggle="tab" aria-controls="div3">
                        <span class="text">Customizable Website</span>
                    </a>
                </li>

                <li role="presentation">
                    <a href="#div4" role="tab"  data-toggle="tab" aria-controls="div4">
                        <span class="text">Publish To Marketplaces</span>
                    </a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="divnew">
                    <h2>Funding Solution</h2>
                    <div class="grids1 col-md-4 col-xs-12"><img src="img/funding.png" class="img-responsive" alt="inventory"/></div>
                    <div class="grids2 col-md-8 col-xs-12">
                        <b>Avail the funding for your inventory & customers in single click! </b>
                        <p>From front-end originations through to back-end collateral management for availing Funding for your Inventory, Working Capital for your Business & Loans for your Customers, DealerPlus leverages scale, support and best-in-class technology to ensure precise data, faster transaction times, and complete servicing for all the requests using innovative and automation systems.</p>           
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="div1">
                    <h2>Inventory Management</h2>
                    <div class="grids1 col-md-4 col-xs-12"><img src="img/inventory-management1.png" class="img-responsive" alt="inventory"/></div>
                    <div class="grids2 col-md-8 col-xs-12">
                        <b>Adding/Managing cars has never been this easy!</b>
                        <p>Our highly advanced integrated inventory system now makes adding cars easy and less tiring, gone are the days of troublesome list generation and management, now say “Hi” to our easy to use inventory system where you can add & manage your list of cars on the fly.</p>           
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="div2">
                    <h2>Mobile friendly</h2>
                    <div class="grids1 col-md-4 col-xs-12"><img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/></div>
                    <div class="grids2 col-md-8 col-xs-12">
                        <p>Your website needs to be attractive on mobile phones and tablets, if you are solely relying on desktop/laptop users then you are missing out on a large commodity of buyers. Our DMS system is build to be mobile friendly, responsive with a superior content management system.</p>             
                    </div> 
                </div>
                <div role="tabpanel" class="tab-pane fade" id="div3" >
                    <h2>Customizable Website</h2>
                    <div class="grids1 col-md-4 col-xs-12"><img src="img/custom.png" class="img-responsive" alt="custom"/></div>
                    <div class="grids2 col-md-8 col-xs-12">
                        <p>Having your own market-place makes a big impression on potential customers and we got this feature specially made for that, with dozens of templates and “click-drag-drop” method of creation, creating and customizing your website is made simple and reliable.</p>             
                    </div>
                </div> 
                <div role="tabpanel" class="tab-pane fade" id="div4" >
                    <h2>Publish To Marketplaces</h2>
                    <div class="grids1 col-md-4 col-xs-12"><img src="img/publish.png" class="img-responsive" alt="publish"/></div>
                    <div class="grids2 col-md-8 col-xs-12">
                        <b>All it takes is one click now!</b>
                        <p>Tired of retyping/entering the same advertisement on multiple website? What if we tell you uploading your stock in our system will get your posts on 1000’s of other websites/portals, yes you heard it right – just upload your stock once and all it takes is a single click for your advertisement to be posted on all the other websites/platforms you can think of!</p>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<section class="col-xs-12 section4 " id="testimonials">
    <div class="row">
        <div class="container">
            <h2>Dealership Success Stories</h2>

            <div id="owl-example1" class="owl-carousel">

                <div class="item">
                    <div class="successsec col-xs-12">
                        <img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/>
                    </div>
                    <h4>Name<span>(Company Name)</span></h4>
                    <p>" Lorem Ipsum is simply dummy text of the printing and typesetting industry."</p>
                    <hr class="hidden-lg hidden-md">
                </div>
                <div class="item">
                    <div class="successsec col-xs-12">
                        <img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/>
                    </div>
                    <h4>Name<span>(Company Name)</span></h4>
                    <p>" Lorem Ipsum is simply dummy text of the printing and typesetting industry."</p>
                    <hr class="hidden-lg hidden-md">
                </div>
                <div class="item">
                    <div class="successsec col-xs-12">
                        <img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/>
                    </div>
                    <h4>Name<span>(Company Name)</span></h4>
                    <p>" Lorem Ipsum is simply dummy text of the printing and typesetting industry."</p>
                    <hr class="hidden-lg hidden-md">
                </div>
                <div class="item">
                    <div class="successsec col-xs-12">
                        <img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/>
                    </div>
                    <h4>Name<span>(Company Name)</span></h4>
                    <p>" Lorem Ipsum is simply dummy text of the printing and typesetting industry."</p>
                    <hr class="hidden-lg hidden-md">
                </div>
                <div class="item">
                    <div class="successsec col-xs-12">
                        <img src="img/mobilefriend.png" class="img-responsive" alt="mobilefriend"/>
                    </div>
                    <h4>Name<span>(Company Name)</span></h4>
                    <p>" Lorem Ipsum is simply dummy text of the printing and typesetting industry."</p>
                    <hr class="hidden-lg hidden-md">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="col-xs-12 section1" id="partners">
    <div class="row">
        <div id="demo">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <h3>Our Partners</h3>
                    </div>
                </div> 
                <div class="row">
                    <div class="span12">                       
                        <div id="owl-example" class="owl-carousel">
                            <div class="item">
                                <img src="img/Chola-Logo.png" alt="logo" class="img-responsive">
                            </div>
                            <div class="item">
                                <img src="img/indianbluebook.png" alt="logo" class="img-responsive">
                            </div>
                            <div class="item">
                                <img src="img/logo-droom.png" alt="logo" class="img-responsive">
                            </div>
                            <div class="item">
                                <img src="img/logo-obv-2.png" alt="logo" class="img-responsive">
                            </div>
                            <div class="item">
                                <img src="img/fastlane.png" alt="logo" class="img-responsive">
                            </div>
                            <div class="item">
                                <img src="img/cars24-logo.jpg" alt="logo" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('index_footer')
</div>
</div>
</body>
<!-- jQuery library -->
<script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/owl.carousel.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function ($) {
    $("#owl-example").owlCarousel({
        autoPlay: 4000, //Set AutoPlay to 3 seconds
        items: 5,
    });
    $("#owl-example1").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        items: 3,
    });
    $('.menuscroll').click(function () {
        $('html, body').animate({
            scrollTop: $($(this).attr('name')).offset().top
        }, 500);
        return false;
    });
});
</script>
<script>
    $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
        var $target = $(e.target);
        var $tabs = $target.closest('.nav-tabs-responsive');
        var $current = $target.closest('li');
        var $parent = $current.closest('li.dropdown');
        $current = $parent.length > 0 ? $parent : $current;
        var $next = $current.next();
        var $prev = $current.prev();
        var updateDropdownMenu = function ($el, position) {
            $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
        };
        $tabs.find('>li').removeClass('next prev');
        $prev.addClass('prev');
        $next.addClass('next');
        updateDropdownMenu($prev, 'left');
        updateDropdownMenu($current, 'center');
        updateDropdownMenu($next, 'right');
    });
</script>
<script type='text/javascript'>var fc_CSS = document.createElement('link');
    fc_CSS.setAttribute('rel', 'stylesheet');
    var fc_isSecured = (window.location && window.location.protocol == 'https:');
    var fc_lang = document.getElementsByTagName('html')[0].getAttribute('lang');
    var fc_rtlLanguages = ['ar', 'he'];
    var fc_rtlSuffix = (fc_rtlLanguages.indexOf(fc_lang) >= 0) ? '-rtl' : '';
    fc_CSS.setAttribute('type', 'text/css');
    fc_CSS.setAttribute('href', ((fc_isSecured) ? 'https://d36mpcpuzc4ztk.cloudfront.net' : 'http://assets1.chat.freshdesk.com') + '/css/visitor' + fc_rtlSuffix + '.css');
    document.getElementsByTagName('head')[0].appendChild(fc_CSS);
    var fc_JS = document.createElement('script');
    fc_JS.type = 'text/javascript';
    fc_JS.defer = true;
    fc_JS.src = ((fc_isSecured) ? 'https://d36mpcpuzc4ztk.cloudfront.net' : 'http://assets.chat.freshdesk.com') + '/js/visitor.js';
    (document.body ? document.body : document.getElementsByTagName('head')[0]).appendChild(fc_JS);
    window.livechat_setting = 'eyJ3aWRnZXRfc2l0ZV91cmwiOiJkZWFsZXJwbHVzLmZyZXNoZGVzay5jb20iLCJwcm9kdWN0X2lkIjpudWxsLCJuYW1lIjoiRGVhbGVyIFBsdXMiLCJ3aWRnZXRfZXh0ZXJuYWxfaWQiOm51bGwsIndpZGdldF9pZCI6IjgzODdlYzVlLWJkYzgtNDA5OS05MDk2LTBjZDJjZGJkZmQwZCIsInNob3dfb25fcG9ydGFsIjpmYWxzZSwicG9ydGFsX2xvZ2luX3JlcXVpcmVkIjpmYWxzZSwibGFuZ3VhZ2UiOiJlbiIsInRpbWV6b25lIjoiRWFzdGVybiBUaW1lIChVUyAmIENhbmFkYSkiLCJpZCI6MjMwMDAwMDY1ODMsIm1haW5fd2lkZ2V0IjoxLCJmY19pZCI6IjMzYmQwN2U1OGFhZjYzMzgzNWI2NGU4ZDg1MmMxYmJhIiwic2hvdyI6MSwicmVxdWlyZWQiOjIsImhlbHBkZXNrbmFtZSI6IkRlYWxlciBQbHVzIiwibmFtZV9sYWJlbCI6Ik5hbWUiLCJtZXNzYWdlX2xhYmVsIjoiTWVzc2FnZSIsInBob25lX2xhYmVsIjoiUGhvbmUiLCJ0ZXh0ZmllbGRfbGFiZWwiOiJUZXh0ZmllbGQiLCJkcm9wZG93bl9sYWJlbCI6IkRyb3Bkb3duIiwid2VidXJsIjoiZGVhbGVycGx1cy5mcmVzaGRlc2suY29tIiwibm9kZXVybCI6ImNoYXQuZnJlc2hkZXNrLmNvbSIsImRlYnVnIjoxLCJtZSI6Ik1lIiwiZXhwaXJ5IjoxNDg4Mjc4MDY5MDAwLCJlbnZpcm9ubWVudCI6InByb2R1Y3Rpb24iLCJlbmRfY2hhdF90aGFua19tc2ciOiJUaGFuayB5b3UhISEiLCJlbmRfY2hhdF9lbmRfdGl0bGUiOiJFbmQiLCJlbmRfY2hhdF9jYW5jZWxfdGl0bGUiOiJDYW5jZWwiLCJzaXRlX2lkIjoiMzNiZDA3ZTU4YWFmNjMzODM1YjY0ZThkODUyYzFiYmEiLCJhY3RpdmUiOjEsInJvdXRpbmciOm51bGwsInByZWNoYXRfZm9ybSI6MSwiYnVzaW5lc3NfY2FsZW5kYXIiOm51bGwsInByb2FjdGl2ZV9jaGF0IjowLCJwcm9hY3RpdmVfdGltZSI6bnVsbCwic2l0ZV91cmwiOiJkZWFsZXJwbHVzLmZyZXNoZGVzay5jb20iLCJleHRlcm5hbF9pZCI6bnVsbCwiZGVsZXRlZCI6MCwibW9iaWxlIjoxLCJhY2NvdW50X2lkIjpudWxsLCJjcmVhdGVkX2F0IjoiMjAxNy0wMi0wM1QxMzoxNDowMi4wMDBaIiwidXBkYXRlZF9hdCI6IjIwMTctMDItMDNUMTM6MTQ6MDkuMDAwWiIsImNiRGVmYXVsdE1lc3NhZ2VzIjp7ImNvYnJvd3Npbmdfc3RhcnRfbXNnIjoiWW91ciBzY3JlZW5zaGFyZSBzZXNzaW9uIGhhcyBzdGFydGVkIiwiY29icm93c2luZ19zdG9wX21zZyI6IllvdXIgc2NyZWVuc2hhcmluZyBzZXNzaW9uIGhhcyBlbmRlZCIsImNvYnJvd3NpbmdfZGVueV9tc2ciOiJZb3VyIHJlcXVlc3Qgd2FzIGRlY2xpbmVkIiwiY29icm93c2luZ19hZ2VudF9idXN5IjoiQWdlbnQgaXMgaW4gc2NyZWVuIHNoYXJlIHNlc3Npb24gd2l0aCBjdXN0b21lciIsImNvYnJvd3Npbmdfdmlld2luZ19zY3JlZW4iOiJZb3UgYXJlIHZpZXdpbmcgdGhlIHZpc2l0b3LigJlzIHNjcmVlbiIsImNvYnJvd3NpbmdfY29udHJvbGxpbmdfc2NyZWVuIjoiWW91IGhhdmUgYWNjZXNzIHRvIHZpc2l0b3LigJlzIHNjcmVlbi4iLCJjb2Jyb3dzaW5nX3JlcXVlc3RfY29udHJvbCI6IlJlcXVlc3QgdmlzaXRvciBmb3Igc2NyZWVuIGFjY2VzcyAiLCJjb2Jyb3dzaW5nX2dpdmVfdmlzaXRvcl9jb250cm9sIjoiR2l2ZSBhY2Nlc3MgYmFjayB0byB2aXNpdG9yICIsImNvYnJvd3Npbmdfc3RvcF9yZXF1ZXN0IjoiRW5kIHlvdXIgc2NyZWVuc2hhcmluZyBzZXNzaW9uICIsImNvYnJvd3NpbmdfcmVxdWVzdF9jb250cm9sX3JlamVjdGVkIjoiWW91ciByZXF1ZXN0IHdhcyBkZWNsaW5lZCAiLCJjb2Jyb3dzaW5nX2NhbmNlbF92aXNpdG9yX21zZyI6IlNjcmVlbnNoYXJpbmcgaXMgY3VycmVudGx5IHVuYXZhaWxhYmxlICIsImNvYnJvd3NpbmdfYWdlbnRfcmVxdWVzdF9jb250cm9sIjoiQWdlbnQgaXMgcmVxdWVzdGluZyBhY2Nlc3MgdG8geW91ciBzY3JlZW4gIiwiY2Jfdmlld2luZ19zY3JlZW5fdmkiOiJBZ2VudCBjYW4gdmlldyB5b3VyIHNjcmVlbiAiLCJjYl9jb250cm9sbGluZ19zY3JlZW5fdmkiOiJBZ2VudCBoYXMgYWNjZXNzIHRvIHlvdXIgc2NyZWVuICIsImNiX3ZpZXdfbW9kZV9zdWJ0ZXh0IjoiWW91ciBhY2Nlc3MgdG8gdGhlIHNjcmVlbiBoYXMgYmVlbiB3aXRoZHJhd24gIiwiY2JfZ2l2ZV9jb250cm9sX3ZpIjoiQWxsb3cgYWdlbnQgdG8gYWNjZXNzIHlvdXIgc2NyZWVuICIsImNiX3Zpc2l0b3Jfc2Vzc2lvbl9yZXF1ZXN0IjoiQWdlbnQgc2Vla3MgYWNjZXNzIHRvIHlvdXIgc2NyZWVuICJ9fQ==';
</script>

</html>