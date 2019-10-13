<div class="ts-main-content dashbord-home">
    <nav class="ts-sidebar  hidden-xs hidden-sm">
        @if($compact_array['active_menu_name']=='buy_menu')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            @if($compact_array['left_menu']=='1')
            <li><a class="sub-active" href="{{url('buy')}}"><i class="fa fa-search"></i> Search</a></li>
            @else
            <li><a href="{{url('buy')}}"><i class="fa fa-search"></i> Search</a></li>
            @endif
            @if($compact_array['left_menu']=='2')
            <li><a class="sub-active" href="{{url('view_savedcars')}}"><i class="fa fa-car"></i> Saved Cars</a></li>
            @else
            <li><a href="{{url('view_savedcars')}}"><i class="fa fa-car"></i> Saved Cars</a></li>
            @endif

            @if($compact_array['left_menu']=='3')
            <li><a class="sub-active" href="{{url('queries_car')}}"><i class="fa fa-question-circle"></i> My Queries</a></li>
            @else
            <li><a href="{{url('queries_car')}}"><i class="fa fa-question-circle"></i> My Queries</a></li>
            @endif
            @if($compact_array['left_menu']=='4')
            <!-- href="bidding_list" -->
            <li><a class="sub-active" ><i class="fa fa-bitbucket-square"></i> Bids Posted <span class="label-danger label">coming soon</span></a></li>
            @else
            <li><a href="#"><i class="fa fa-bitbucket-square"></i> Bids Posted <span class="label-danger label">coming soon</span></a></li>
            @endif
            <!-- @if($compact_array['left_menu']=='5')
            <li><a class="sub-active" href="apply_inventory_fund"><i class="fa fa-money"></i> Apply Inventory Funding</a></li>
            @else
            <li><a href="apply_inventory_fund"><i class="fa fa-money"></i> Apply Inventory Funding</a></li>
            @endif -->
            @if($compact_array['left_menu']=='6')
            <li><a class="sub-active" href="{{url('alert')}}"><i class="fa fa-bell"></i> Alerts </a></li>
            @else
            <li><a href="{{url('alert')}}"><i class="fa fa-bell"></i> Alerts</a></li>
            @endif
        </ul>
        @elseif($compact_array['active_menu_name']=='sell_menu')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            @if($compact_array['side_bar_active'] == 1)
            <li><a class="sub-active" href="{{url('managelisting')}}"><i class="fa fa-sellsy"></i>My Inventory</a></li>
            @else
            <li><a class="sub" href="{{url('managelisting')}}"><i class="fa fa-sellsy"></i>My Inventory</a></li>
            @endif
            @if($compact_array['side_bar_active'] == 2)
            <li><a class="sub-active" href="{{url('myposting')}}"><i class="fa fa-dropbox"></i> My Postings</a></li>
            @else
            <li><a href="{{url('myposting')}}"><i class="fa fa-dropbox"></i> My Postings</a></li>
            @endif
            @if($compact_array['side_bar_active'] == 3)
            <li><a  class="sub-active" href="{{url('#')}}"><i class="fa fa-archive"></i> My Auction <span class="label-danger label">coming soon</span></a></li>
            @else
            <!-- href="{{url('myauction.html')}}" -->
            <li><a ><i class="fa fa-archive"></i> My Auction <span class="label-danger label">coming soon</span></a></li>
            @endif
            @if($compact_array['side_bar_active'] == 4)
            <li><a class="sub-active" href="{{url('doQueriesReceived')}}"><i class="fa fa-question"></i>Queries Received</a></li>
            @else
            <li><a href="{{url('doQueriesReceived')}}"><i class="fa fa-question"></i>Queries Received</a></li>
            @endif
            <!-- @if($compact_array['side_bar_active'] == 5)
            <li><a class="sub-active" href="{{url('loanforcustomer')}}"><i class="fa fa-ticket"></i> Apply Loan For Customers</a></li>
            @else
            <li><a href="{{url('loanforcustomer')}}"><i class="fa fa-ticket"></i> Apply Loan For Customers</a></li>
            @endif -->
        </ul>
        @elseif($compact_array['active_menu_name']=='manage_menu')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            @if($header_data['p_id'] == 0)

            @if($compact_array['side_bar_active']=='profile')
            <li><a class="sub-active" href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            @else
            <li><a href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            @endif
            @if($compact_array['side_bar_active']=='change_password')
            <li><a class="sub-active" href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
            @else
            <li><a href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
            @endif
            @if($compact_array['side_bar_active']=='businessprofile')
            <li><a class="sub-active" href="{{url('business_profile')}}"><i class="fa fa-user"></i>  My Business Profile</a></li>
            @else
            <li><a href="{{url('business_profile')}}"><i class="fa fa-user"></i> My Business Profile</a></li>
            @endif                
            @if($compact_array['side_bar_active']=='branch')
            <li><a class="sub-active" href="{{url('managebranches')}}"><i class="fa fa-sitemap"></i> My Branches</a></li>
            @else
            <li><a href="{{url('managebranches')}}"><i class="fa fa-sitemap"></i> My Branches</a></li>
            @endif       
            @if($compact_array['side_bar_active']=='contact')
            <li><a class="sub-active contact" href="{{url('managecontact')}}"><i class="fa fa-phone-square active"></i> My Contacts</a></li>
            @else
            <li><a href="{{url('managecontact')}}"><i class="fa fa-phone-square active"></i> My Contacts</a></li>
            @endif
            @if($compact_array['side_bar_active']=='network')
            <li><a class="sub-active" href="{{url('group')}}"><i class="fa fa-group"></i>My Networks</a></li>
            @else
            <li><a href="{{url('group')}}"><i class="fa fa-group"></i>My Networks</a></li>
            @endif
            @if($compact_array['side_bar_active']=='user')
            <li><a class="sub-active" href="{{url('manageuser')}}"><i class="fa fa-users"></i> My Users</a></li>
            @else
            <li><a href="{{url('manageuser')}}"><i class="fa fa-users"></i> My Users</a></li>
            @endif
            @if($compact_array['side_bar_active']=='employee')
            <li><a class="sub-active" href="{{url('manageEmployee')}}"><i class="fa fa-users"></i> My Employee</a></li>
            @else
            <li><a href="{{url('manageEmployee')}}"><i class="fa fa-users"></i> My Employee</a></li>
            @endif
            <!-- @if($compact_array['side_bar_active']=='subscription')
            <li><a class="sub-active" href="{{url('managesubscription')}}"><i class="fa fa-street-view"></i>Subscription</a></li>
            @else
            <li><a href="{{url('managesubscription')}}"><i class="fa fa-street-view"></i>Subscription</a></li>
            @endif -->
            @if($compact_array['side_bar_active']=='transaction')
            <li><a class="sub-active" href="{{url('managetransaction')}}"><i class="fa fa-credit-card"></i>Transaction</a></li>
            @else
            <li><a href="{{url('managetransaction')}}"><i class="fa fa-credit-card"></i>Transaction</a></li>
            @endif
            @else
            @if($compact_array['side_bar_active']=='profile')
            <li><a class="sub-active" href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            @else
            <li><a href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            @endif
            @if($compact_array['side_bar_active']=='change_password')
            <li><a class="sub-active" href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
            @else
            <li><a href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
            @endif               
            @if($compact_array['side_bar_active']=='contact')
            <li><a class="sub-active contact" href="{{url('managecontact')}}"><i class="fa fa-phone-square active"></i> My Contacts</a></li>
            @else
            <li><a href="{{url('managecontact')}}"><i class="fa fa-phone-square active"></i> My Contacts</a></li>
            @endif                
            @if($compact_array['side_bar_active']=='employee')
            <li><a class="sub-active" href="{{url('manageEmployee')}}"><i class="fa fa-users"></i> My Employee</a></li>
            @else
            <li><a href="{{url('manageEmployee')}}"><i class="fa fa-users"></i> My Employee</a></li>
            @endif
            @endif
        </ul>
        @elseif($compact_array['active_menu_name']=='fund_menu')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            @if($compact_array['left_menu']=='1')
            <li><a class="sub-active" href="{{url('viewfunding')}}"><i class="fa fa-money"></i> Inventory Funding</a></li>
            @else
            <li><a href="{{url('viewfunding')}}"><i class="fa fa-money"></i> Inventory Funding</a></li>
            @endif
            @if($compact_array['left_menu'] == 2)
            <li><a class="sub-active" href="{{url('viewloan')}}"><i class="fa fa-ticket"></i> Loan For Customers</a></li>
            @else
            <li><a href="{{url('viewloan')}}"><i class="fa fa-ticket"></i> Loan For Customers</a></li>
            @endif
        </ul>
        @elseif($compact_array['active_menu_name']=='network')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            <li><a class="sub-active" href="{{url('group')}}"><i class="fa fa-group"></i>Groups</a></li> 
            <li><a href="{{url('emailtemplate')}}"><i class="fa fa-dropbox"></i>Email Template</a></li> 
            <li><a href="{{url('smstemplate')}}"><i class="fa fa-dropbox"></i>SMS Template</a></li> 
        </ul>

        @elseif($compact_array['active_menu_name']=='manage_menu')
        @if($header_data['p_id'] == 0)
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            <li><a href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            <li><a href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
            <li><a href="{{url('managebranches')}}"><i class="fa fa-sitemap"></i> My Branches</a></li>
            <li><a class="sub-active contact" href="{{url('managecontact')}}"><i class="fa fa-phone-square active"></i> My Contacts</a></li>
            <li><a href="{{url('manageuser')}}"><i class="fa fa-users"></i> My Users</a></li>
            <li><a href="{{url('manageEmployee')}}"><i class="fa fa-users"></i> My Employee</a></li>
            <!-- <ul>
                <li><a href="emailtemp.html">Email Template</a></li>
                <li><a href="smstemp.html">SMS Template</a></li>
            </ul>
            </li>
            <li><a href="myauction.html"><i class="fa fa-envelope"></i> Message</a></li>
            <li><a href="queries.html"><i class="fa fa-life-saver"></i>Marketing</a></li> -->
        </ul>
        @else
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            <li><a href="{{url('myeditaccount')}}"><i class="fa fa-user"></i> My Profile</a></li>
            <li><a href="{{url('dealerchangepassword')}}"><i class="fa fa-user"></i> Change Password</a></li>
        </ul>
        @endif
        @elseif($compact_array['active_menu_name']=='accounts')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            <li>
                @if($compact_array['side_bar_active']=='1')
                <a href="{{url('/manage_invoice')}}" class="sub-active"><i class="fa fa-file-text-o"></i>Invoice </a>
                @else
                <a href="{{url('/manage_invoice')}}"><i class="fa fa-file-text-o"></i>Invoice</a>
                @endif
            </li>
            <li>
                @if($compact_array['side_bar_active']=='2')
                <a href="{{url('/managequotes')}}" class="sub-active"><i class="fa fa-file-text-o"></i>Quotes </a>
                @else
                <a href="{{url('/managequotes')}}"><i class="fa fa-file-text-o"></i>Quotes</a>
                @endif
            </li>
        </ul>
        @elseif($compact_array['active_menu_name']=='reports_menu')
        <ul class="ts-sidebar-menu  hidden-xs hidden-sm">
            <li>
                @if($compact_array['side_bar_active']=='1')
                <a href="{{url('/reports')}}" class="sub-active"><i class="fa fa-file-text-o"></i>Inventory Reports</a>
                @else
                <a href="{{url('/reports')}}"><i class="fa fa-file-text-o"></i>Inventory Reports</a>
                @endif
            </li>
            <li>
                @if($compact_array['side_bar_active']=='2')
                <a href="{{url('/inventory-age-report')}}" class="sub-active"><i class="fa fa-user"></i>Inventory Age Reports</a>
                @else
                <a href="{{url('/inventory-age-report')}}"><i class="fa fa-user"></i>Inventory Age Reports</a>
                @endif
            </li>
            <li>
                @if($compact_array['side_bar_active']=="3")
                <a class="sub-active" href="{{url('/contact_reports')}}"><i class="fa fa-user"></i>Contacts Reports </a>
                @else
                <a href="{{url('/contact_reports')}}"><i class="fa fa-user"></i>Contacts Reports</a>
                @endif
            </li>
            <li>
                @if($compact_array['side_bar_active']=="4")
                <a class="sub-active" href="{{url('/sales_reports')}}"><i class="fa fa-line-chart"></i>Sales Reports </a>
                @else
                <a href="{{url('/sales_reports')}}"><i class="fa fa-line-chart"></i>Sales Reports </a>
                @endif
            </li>
            <li>
                @if($compact_array['side_bar_active'] == '5')
                <a class="sub-active" href="{{url('/alert-reports')}}" class="sub-active"><i class="fa fa-bell-o"></i>Alerts Reports</a>
                @else
                <a href="{{url('/alert-reports')}}"><i class="fa fa-bell-o"></i>Alerts Reports</a>
                @endif
            </li>            
        </ul>
        @endif
        <ul class="ts-sidebar-shortlist hidden-sm hidden-xs">
            <li class="savedlist">
                <a href="{{url('view_savedcars')}}"><div><i class="fa fa-heart"></i> <span class="add-count">({{$header_data['savedcount']}})</span></div><div>Shortlist</div></a>
            </li>
            <li>
                <a href="{{url('recentviewed')}}"> <div><i class="fa fa-eye"></i> <span class="add-count">( @if($header_data['recentcount']<=10) {{$header_data['recentcount']}} @else 10 @endif)</span></div><div>Recent View</div></a>
            </li>
            <li class="comparepage savedlist">
                <a><div><i class="fa fa-balance-scale"></i> <span class="add-count compare-count">(0)</span></div>
                    <div>Compare</div> </a>
            </li>

        </ul>
    </nav>
    <!-- Account from above -->
    <!-- Below for mobile side bar -->
    <nav class="ts-sidebar hidden-lg hidden-md">
        <ul class="ts-profile-nav ts-sidebar-menu">

            <li class="active"><a href="dashboard">Dashboard</a></li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="buy">Buy</a>
                <ul class="dropdown-menu">
                    <li><a href="buy">Search</a></li>
                    <li><a href="view_savedcars">Saved Cars</a></li>
                    <li><a class="test"  href="queries_car">My Queries</a></li>
                    <li><a href="bidding_list">Bids Posted</a></li>
                    <li><a href="apply_inventory_fund">Inventory Funding</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="listing.html">Sell</a>
                <ul class="dropdown-menu">
                    <li><a href="managelisting">My Inventory</a></li>
                    <li><a href="myposting">My Postings</a></li>
                    <li><a class="test" href="myauction.html">My Auctions</a></li>
                    <li><a href="doQueriesReceived">Queries Received</a></li>
                    <li><a href="loanforcustomer">Loan For Customers</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="managelisting">Manage</a>
                @if($header_data['p_id'] == 0)
                <ul class="dropdown-menu">
                    <li><a href="myeditaccount">My Profile</a></li>
                    <li><a href="dealerchangepassword">Change Password</a></li>
                    <li><a href="managebranches">My Branches</a></li>
                    <li><a href="managecontact">My Contacts</a></li>
                    <li><a href="manageuser">My Users</a></li>
                    <li><a href="manageEmployee">My Employee</a></li>
                    <li><a href="managesubscription">Subscriptions</a></li>
                    <li><a href="managetransaction">Transaction</a></li>
                </ul>
                @else
                <ul class="dropdown-menu">
                    <li><a href="myeditaccount">My Profile</a></li>
                    <li><a href="dealerchangepassword">Change Password</a></li>                    
                    <li><a href="managecontact">My Contacts</a></li>                    
                    <li><a href="manageEmployee">My Employee</a></li>                    
                </ul>
                @endif
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="myaccount.html">Network</a>
                <ul class="dropdown-menu">
                    <li><a href="#">My Groups</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a class="test" href="#">Promotions</a></li>
                    <li><a href="#">Notifications</a></li>
                    <li><a href="#">Messages</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="myaccount.html">Accounts</a>
                <ul class="dropdown-menu">
                    <!--                    <li><a href="#">Invoices</a></li>
                                        <li><a href="#">Quotes</a></li>
                                        <li><a href="#">Payments</a></li>-->
                    <li>
                        <a href="manage_invoice" class="sub-active">Invoice </a></li>
                    <li><a href="managequotes" class="sub-active">Quotes </a></li>

                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="detail-list.html">Reports</a>
                <ul class="dropdown-menu">
                    <!-- <li><a href="#">Sales</a></li>
                    <li><a href="#">Inventory</a></li>
                    <li><a class="test" href="#">Expenses</a></li>
                    <li><a href="#">Profit & Loss</a></li>
                    <li><a href="#">User Reports</a></li>-->
                    <li><a href="reports">Inventory Reports</a></li>
                    <li><a href="inventory-age-report">Inventory Age Reports</a></li>
                    <li><a class="test" href="contact_reports">Contacts Reports</a></li>
                    <li><a href="sales_reports">Sales Reports</a></li>
                    <li><a href="alert-reports">Alerts Reports</a></li>
                </ul>
            </li>

            <li class="ts-account">
                <a href="{{url('myeditaccount')}}">
                    <img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt="">My Account <i class="fa fa-angle-down hidden-side"></i>
                </a>
            </li>
            <li><a href="{{url('dealerchangepassword')}}">Change Password</a></li>            
            <li><a href="{{url('logout')}}">Logout</a></li>
<!--            <li class="notification"><a href="{{url('alert')}}"><i class="fa fa-bell"></i><span>1</span></a></li>-->
<!--            <li class="notification1"><a href="#"><i class="fa fa-comment"></i><span>3</span></a></li>-->
        </ul>

    </nav>
    <form method="post" id="compare_data_form" action="{{url('compare')}}">
        <input type="hidden" name="compare_data_text"  id="compare_data_text" value="">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
