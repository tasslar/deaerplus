 <nav class="ts-sidebar">
                <ul class="ts-sidebar-menu hidden-sm hidden-xs">
                    <!--<li class="ts-label">Search</li>
                    <li>
                            <input type="text" class="ts-sidebar-search" placeholder="Search here...">
                    </li>-->

                    @if($compact_array['side_bar_active']=='branch')
                    <li><a class="sub-active" href="{{url('managelisting')}}"><i class="fa fa-sellsy"></i>My Inventory</a></li>
                    @else
                    <li><a href="{{url('managelisting')}}"><i class="fa fa-sellsy"></i>My Inventory</a></li>
                    @endif
                    @if($compact_array['side_bar_active']=='mypost')
                    <li><a class="sub-active" href="{{url('myposting')}}"><i class="fa fa-dropbox"></i> My Postings</a>
                    @else
                    <li><a href="{{url('myposting')}}"><i class="fa fa-dropbox"></i> My Postings</a>
                    @endif
                        <!--<ul>
                                <li><a href="managelisting.html">Manage Listing</a></li>
                                <li><a href="listing.html">Buy Listing</a></li>
                                </ul>-->
                    </li>
                    <li><a href="myauction.html"><i class="fa fa-archive"></i> My Auction</a></li>
                    <li><a href="queries.html"><i class="fa fa-question"></i>Queries Received</a></li>
                    <li><a href="apply-loan.html"><i class="fa fa-ticket"></i> Apply Loan For Customers</a></li>
                </ul>
                <!-- Account from above -->
                <ul class="ts-profile-nav ts-sidebar-menu">

                    <li class="ts-account">
                        <a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a></li>
                    <li><a href="myaccount.html">My Account</a></li>
                    <li><a href="#">Edit Account</a></li>
                    <li><a href="#">Logout</a></li>
                    <li class="notification"><a href="#"><i class="fa fa-envelope"></i><span>1</span></a></li>
                    <li class="notification1"><a href="#"><i class="fa fa-comment"></i><span>3</span></a></li>
                </ul>

            </nav>