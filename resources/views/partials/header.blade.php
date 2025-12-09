<header class="codex-header">
    <div class="header-contian d-flex justify-content-between align-items-center">
        <div class="header-left d-flex align-items-center">
            <div class="sidebar-action navicon-wrap"><i data-feather="menu"></i></div>
            {{--  <div class="search-bar">
                <div class="form-group mb-0">
                    <div class="input-group">
                        <input class="form-control" type="text" value="" placeholder="Search Here....."><span
                            class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="header-right d-flex align-items-center justify-content-end">
            <ul class="nav-iconlist">
                {{-- 
                <li>
                    <div class="navicon-wrap action-dark"><i class="fa fa-moon-o icon-dark"></i><i
                            class="fa fa-sun-o icon-light" style="display:none;"></i></div>
                </li>
                <li>
                    <div class="navicon-wrap"><i data-feather="bell"></i>
                        <div class="noti-count">88</div>
                    </div>
                     
                    <div class="hover-dropdown navnotification-drop">
                        <div class="drop-header">
                            <h5>notification<span>88</span></h5>
                        </div>
                        <ul data-simplebar>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-primary"><i class="fa fa-check-square-o"></i></div>
                                        <div class="media-body">
                                            <h6>order Cheked</h6><span class="text-light">1 hour ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-secondary"><i class="fa fa-first-order"></i></div>
                                        <div class="media-body">
                                            <h6>order receved</h6><span class="text-light">1 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-success"><i class="fa fa-money"></i></div>
                                        <div class="media-body">
                                            <h6>payment received</h6><span class="text-light">2 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-warning"><i class="fa fa-truck"></i></div>
                                        <div class="media-body">
                                            <h6>order shipped</h6><span class="text-light">2 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-info"><i class="fa fa-first-order"></i></div>
                                        <div class="media-body">
                                            <h6>order receved</h6><span class="text-light">1 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-success"><i class="fa fa-money"></i></div>
                                        <div class="media-body">
                                            <h6>payment received</h6><span class="text-light">2 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-warning"><i class="fa fa-truck"></i></div>
                                        <div class="media-body">
                                            <h6>order shipped</h6><span class="text-light">2 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <div class="media">
                                        <div class="icon-nav bg-info"><i class="fa fa-first-order"></i></div>
                                        <div class="media-body">
                                            <h6>order receved</h6><span class="text-light">1 day ago</span>
                                        </div>
                                    </div>
                                </a></li>
                        </ul> 
                        <div class="drop-footer"><a href="email-inbox.html">See All Notification</a></div>
                    </div>
                </li>
           
                <li>
                    <div class="navicon-wrap btn-windowfull"><i data-feather="maximize"></i></div>
                </li>
            --}}
                <li class="nav-profile">
                    <div class="media">
                        <div class="user-icon"><img class="img-fluid rounded-50"
                                src="{{ asset('assets/images/avtar/profile.jpg') }}" alt=""></div>
                        <div class="media-body">
                            <h6>{{ Auth::user()->name }}</h6><span
                                class="text-light">{{ Auth::user()->getRoleNames()->first() }}</span>
                        </div>
                    </div>
                    <div class="hover-dropdown navprofile-drop">
                        <ul>
                            {{--  
                                <li><a href="profile.html"><i class="ti-user"></i>profile</a></li>
                                <li><a href="email-inbox.html"><i class="ti-email"></i>inbox</a></li>
                                <li><a href="user-edit.html"><i class="ti-settings"></i>setting</a></li>
                            --}}
                            <li><a href="{{ route('profile.show') }}">Profile</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i>Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
