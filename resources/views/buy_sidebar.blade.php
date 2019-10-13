<div class="brand1 clearfix hidden-md hidden-lg"><nav class="navbar navbar-inverse">

    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle mobile-view" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Main Menu</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="index.html">Buy<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="buy">Search</a></li>
                        <li><a href="view_savedcars">Saved Cars</a></li>
                        <li class="dropdown-submenu">
                            <a class="test"  href="queries_car">My Queries <span class="caret"></span></a>
                            <!--<ul class="dropdown-menu">
                              <li><a href="#">2nd level dropdown</a></li>
                              <li><a href="#">2nd level dropdown</a></li>
                              </ul>-->
                        </li>
                        <li><a href="bidding_list">Bids Posted</a></li>
                        <li><a href="apply_inventory_fund">Apply Inventory Funding</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="listing.html">Sell<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="inventory.html">My Inventory</a></li>
                        <li><a href="myposting.html">My Postings</a></li>
                        <li class="dropdown-submenu">
                            <a class="test" href="myauction.html">My Auctions <span class="caret"></span></a>
                            <!--<ul class="dropdown-menu">
                              <li><a href="#">2nd level dropdown</a></li>
                              <li><a href="#">2nd level dropdown</a></li>
                              </ul>-->
                        </li>
                        <li><a href="queries.html">Queries Received</a></li>
                        <li><a href="apply-loan.html">Apply Loan For Customers</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="managelisting.html">Manage <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="myprofile.html">My Profile</a></li>
                        <li><a href="mybranch.html">My Branches</a></li>
                        <li><a href="myleads.html">My Leads</a></li>
                        <li class="dropdown-submenu">
                            <a class="test" href="mycustomer.html">My Customer <span class="caret"></span></a>
                            <!--<ul class="dropdown-menu">
                              <li><a href="#">2nd level dropdown</a></li>
                              <li><a href="#">2nd level dropdown</a></li>
                              </ul>-->
                        </li>
                        <li><a href="Mycontact.html">My Contacts</a></li>
                        <li><a href="myuser.html">My Users</a></li>
                        <li><a href="subscription.html">Subscriptions</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="myaccount.html">Communication <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">My Groups</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li class="dropdown-submenu">
                            <a class="test" href="#">Promotions<span class="caret"></span></a>
                            <!--<ul class="dropdown-menu">
                              <li><a href="#">2nd level dropdown</a></li>
                              <li><a href="#">2nd level dropdown</a></li>
                              </ul>--></li>
                        <li><a href="#">Notifications</a></li>
                        <li><a href="#">Messages</a></li>

                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="detail-list.html">Reports <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sales</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li class="dropdown-submenu">
                            <a class="test" href="#">Expenses<span class="caret"></span></a>
                            <!--<ul class="dropdown-menu">
                              <li><a href="#">dropdown</a></li>
                              <li><a href="#">dropdown</a></li>
                              </ul>--></li>
                        <li><a href="#">Profit & Loss</a></li>
                        <li><a href="#">User Reports</a></li>

                    </ul>
                </li></ul>
        </div>
    </div>
</nav>
</div>
<div class="ts-main-content">
	<nav class="ts-sidebar">
	    <ul class="ts-sidebar-menu hidden-sm hidden-xs">
	       @if($compact_array['left_menu']=='1')
	        <li><a class="sub-active" href="buy"><i class="fa fa-search"></i> Search</a></li>
            @else
            <li><a class="" href="buy"><i class="fa fa-search"></i> Search</a></li>
            @endif
            @if($compact_array['left_menu']=='2')
            <li><a class="sub-active" href="view_savedcars"><i class="fa fa-car"></i>Saved Cars</a></li>
            @else
            <li><a class="" href="view_savedcars"><i class="fa fa-car"></i>Saved Cars</a></li>
            @endif
            @if($compact_array['left_menu']=='3')
            <li><a class="sub-active" href="queries_car"><i class="fa fa-question-circle"></i>My Queries</a></li>
            @else
            <li><a class="" href="queries_car"><i class="fa fa-question-circle"></i>My Queries</a></li>
            @endif
            @if($compact_array['left_menu']=='4')
            <li><a class="sub-active" href="bidding_list"><i class="fa fa-bitbucket-square"></i>Bids Posted</a></li>
            @else
            <li><a class="" href="bidding_list"><i class="fa fa-bitbucket-square"></i>Bids Posted</a></li>
            @endif
            @if($compact_array['left_menu']=='5')
            <li><a class="sub-active" href="apply_inventory_fund"><i class="fa fa-money"></i>Apply Inventory Funding</a></li>
            @else
            <li><a class="" href="apply_inventory_fund"><i class="fa fa-money"></i>Apply Inventory Funding</a></li>
            @endif
	    </ul>
	    <!-- Account from above -->
	    <ul class="ts-profile-nav ts-sidebar-menu">
	        <li class="ts-account"><a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a></li>
	        <li><a href="myaccount.html">My Account</a></li>
	        <li><a href="#">Edit Account</a></li>
	        <li><a href="#">Logout</a></li>
	        <li class="notification"><a href="#"><i class="fa fa-envelope"></i><span>1</span></a></li>
	        <li class="notification1"><a href="#"><i class="fa fa-comment"></i><span>3</span></a></li>
	    </ul>
	</nav>